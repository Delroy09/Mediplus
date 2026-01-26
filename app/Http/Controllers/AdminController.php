<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingRequests = AccountRequest::where('status', 'pending')->get();
        $recentRequests = AccountRequest::whereIn('status', ['approved', 'rejected'])
            ->orderBy('reviewed_at', 'desc')
            ->take(10)
            ->get();

        $doctors = Doctor::with('user')
            ->withCount(['patients' => function ($query) {
                $query->where('patient_doctor_assignments.is_active', true);
            }])
            ->get();

        $patients = Patient::with(['user', 'doctors' => function ($query) {
            $query->wherePivot('is_active', true)->with('user');
        }])->get();

        return view('admin.dashboard', compact('pendingRequests', 'recentRequests', 'doctors', 'patients'));
    }

    public function approveRequest(Request $request, $id)
    {
        $accountRequest = AccountRequest::findOrFail($id);

        if ($accountRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Request already processed.');
        }

        // Validate doctor selection
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id'
        ]);

        DB::transaction(function () use ($accountRequest, $request) {
            // Create user account
            $user = User::create([
                'name' => $accountRequest->name,
                'email' => $accountRequest->email,
                'password' => Hash::make('password'), // Default password
                'role' => $accountRequest->requested_role,
            ]);

            // Create patient or doctor record
            if ($accountRequest->requested_role === 'patient') {
                $patient = Patient::create([
                    'user_id' => $user->id,
                    'mobile_number' => $accountRequest->mobile_number,
                    'blood_group' => 'O+', // Default, user can update
                    'dob' => '2000-01-01', // Default, user can update
                    'gender' => 'male', // Default, user can update
                    'address' => 'Address not provided',
                    'status' => 'Admitted',
                ]);

                // Assign to selected doctor
                \App\Models\PatientDoctorAssignment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $request->doctor_id,
                    'assigned_date' => now(),
                    'is_active' => true,
                    'assigned_by' => Auth::id(),
                    'notes' => 'Assigned by admin on account approval',
                ]);
            }

            // Update request status
            $accountRequest->update([
                'status' => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Account request approved and user created successfully.');
    }

    public function rejectRequest(Request $request, $id)
    {
        $accountRequest = AccountRequest::findOrFail($id);

        if ($accountRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'Request already processed.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $accountRequest->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Account request rejected.');
    }

    public function reassignDoctor(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $request->validate([
            'doctor_id' => 'required|exists:doctors,id'
        ]);

        DB::transaction(function () use ($patient, $request) {
            // Deactivate all current assignments
            \App\Models\PatientDoctorAssignment::where('patient_id', $patient->id)
                ->update([
                    'is_active' => false,
                    'unassigned_date' => now()
                ]);

            // Create new assignment to selected doctor
            \App\Models\PatientDoctorAssignment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'assigned_date' => now(),
                'is_active' => true,
                'assigned_by' => Auth::id(),
                'notes' => 'Reassigned by admin',
            ]);
        });

        return redirect()->back()->with('success', 'Patient reassigned to new doctor successfully.');
    }

    // =============================================
    // V2 Methods (New UI - Same functionality)
    // =============================================

    /**
     * V2 Admin Dashboard
     */
    public function dashboardV2()
    {
        $totalDoctors = Doctor::count();
        $totalPatients = Patient::count();
        $pendingRequests = AccountRequest::where('status', 'pending')->count();
        $totalAssignments = \App\Models\PatientDoctorAssignment::where('is_active', true)->count();

        $pendingDeletionRequests = collect([]); // TODO: Implement deletion requests table

        $recentDoctors = Doctor::with('user')
            ->withCount(['patients' => function ($query) {
                $query->where('patient_doctor_assignments.is_active', true);
            }])
            ->latest()
            ->take(5)
            ->get();

        $recentPatients = Patient::with(['user', 'doctors' => function ($query) {
            $query->wherePivot('is_active', true)->with('user');
        }])
            ->latest()
            ->take(5)
            ->get();

        return view('NewUI.admin.dashboard_v2', compact(
            'totalDoctors',
            'totalPatients',
            'pendingRequests',
            'totalAssignments',
            'pendingDeletionRequests',
            'recentDoctors',
            'recentPatients'
        ));
    }

    /**
     * V2 Doctors List
     */
    public function doctorsV2()
    {
        $doctors = Doctor::with('user')
            ->withCount(['patients' => function ($query) {
                $query->where('patient_doctor_assignments.is_active', true);
            }])
            ->get();

        return view('NewUI.admin.doctors_v2', compact('doctors'));
    }

    /**
     * V2 View Doctor
     */
    public function viewDoctorV2($id)
    {
        $doctor = Doctor::with(['user', 'patients.user'])->findOrFail($id);

        return view('NewUI.admin.doctor-view_v2', compact('doctor'));
    }

    /**
     * V2 Edit Doctor Form
     */
    public function editDoctorV2($id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);

        return view('NewUI.admin.doctor-edit_v2', compact('doctor'));
    }

    /**
     * Update Doctor
     */
    public function updateDoctor(Request $request, $id)
    {
        $doctor = Doctor::with('user')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'specialization' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'consultation_hours' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($doctor, $validated) {
            $doctor->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $doctor->update([
                'specialization' => $validated['specialization'],
                'department' => $validated['department'],
                'qualification' => $validated['qualification'],
                'years_of_experience' => $validated['experience'],
                'consultation_hours' => $validated['consultation_hours'],
            ]);
        });

        return redirect()->route('admin.doctor.view.v2', $id)->with('success', 'Doctor updated successfully.');
    }

    /**
     * V2 Create Doctor Form
     */
    public function createDoctorV2()
    {
        return view('NewUI.admin.doctor-create_v2');
    }

    /**
     * Store Doctor
     */
    public function storeDoctor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'specialization' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'consultation_hours' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'doctor',
            ]);

            Doctor::create([
                'user_id' => $user->id,
                'specialization' => $validated['specialization'],
                'department' => $validated['department'],
                'qualification' => $validated['qualification'],
                'years_of_experience' => $validated['experience'],
                'consultation_hours' => $validated['consultation_hours'],
            ]);
        });

        return redirect()->route('admin.doctors.v2')->with('success', 'Doctor account created successfully.');
    }

    /**
     * Delete Doctor
     */
    public function deleteDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);

        DB::transaction(function () use ($doctor) {
            // Deactivate all assignments
            \App\Models\PatientDoctorAssignment::where('doctor_id', $doctor->id)->delete();

            // Delete doctor record
            $doctor->delete();

            // Delete user account
            User::where('id', $doctor->user_id)->delete();
        });

        return redirect()->route('admin.doctors.v2')->with('success', 'Doctor deleted successfully.');
    }

    /**
     * V2 Patients List
     */
    public function patientsV2(Request $request)
    {
        $query = Patient::with(['user', 'doctors' => function ($q) {
            $q->wherePivot('is_active', true)->with('user');
        }]);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $patients = $query->get();

        return view('NewUI.admin.patients_v2', compact('patients'));
    }

    /**
     * V2 View Patient
     */
    public function viewPatientV2($id)
    {
        $patient = Patient::with(['user', 'doctors.user'])->findOrFail($id);
        $medicalRecords = \App\Models\MedicalRecord::where('patient_id', $id)
            ->with('doctor.user')
            ->latest()
            ->get();

        return view('NewUI.admin.patient-view_v2', compact('patient', 'medicalRecords'));
    }

    /**
     * V2 Assign Patient Form
     */
    public function assignPatientV2($id)
    {
        $patient = Patient::with(['user', 'doctors'])->findOrFail($id);
        $doctors = Doctor::with('user')
            ->withCount(['patients' => function ($q) {
                $q->where('patient_doctor_assignments.is_active', true);
            }])
            ->get();

        $assignedDoctorIds = $patient->doctors()->wherePivot('is_active', true)->pluck('doctors.id')->toArray();

        return view('NewUI.admin.patient-assign_v2', compact('patient', 'doctors', 'assignedDoctorIds'));
    }

    /**
     * Assign Patient to Doctor
     */
    public function assignPatientPost(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $request->validate([
            'doctor_id' => 'required|exists:doctors,id'
        ]);

        // Check if already assigned
        $existing = \App\Models\PatientDoctorAssignment::where('patient_id', $patient->id)
            ->where('doctor_id', $request->doctor_id)
            ->where('is_active', true)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Patient is already assigned to this doctor.');
        }

        \App\Models\PatientDoctorAssignment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'assigned_date' => now(),
            'is_active' => true,
            'assigned_by' => Auth::id(),
            'notes' => 'Assigned by admin',
        ]);

        return redirect()->route('admin.patient.view.v2', $id)->with('success', 'Doctor assigned successfully.');
    }

    /**
     * V2 Assignments List
     */
    public function assignmentsV2()
    {
        $assignments = \App\Models\PatientDoctorAssignment::where('is_active', true)
            ->with(['patient.user', 'doctor.user'])
            ->latest()
            ->get();

        $doctors = Doctor::with('user')->get();

        // Get all patients (not just unassigned ones) - admin can create multiple assignments
        $patients = Patient::with('user')->get();

        return view('NewUI.admin.assignments_v2', compact('assignments', 'doctors', 'patients'));
    }

    /**
     * Store Assignment
     */
    public function storeAssignment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id'
        ]);

        // Check if already assigned
        $existing = \App\Models\PatientDoctorAssignment::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->where('is_active', true)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'This assignment already exists.');
        }

        \App\Models\PatientDoctorAssignment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'assigned_date' => now(),
            'is_active' => true,
            'assigned_by' => Auth::id(),
            'notes' => 'Assigned by admin',
        ]);

        return redirect()->back()->with('success', 'Assignment created successfully.');
    }

    /**
     * Delete Assignment
     */
    public function deleteAssignment($id)
    {
        $assignment = \App\Models\PatientDoctorAssignment::findOrFail($id);
        $assignment->update([
            'is_active' => false,
            'unassigned_date' => now()
        ]);

        return redirect()->back()->with('success', 'Assignment removed successfully.');
    }

    /**
     * Approve Deletion Request
     */
    public function approveDeletion($id)
    {
        // TODO: Implement deletion request approval
        return redirect()->back()->with('success', 'Deletion request approved.');
    }

    /**
     * Reject Deletion Request
     */
    public function rejectDeletion($id)
    {
        // TODO: Implement deletion request rejection
        return redirect()->back()->with('success', 'Deletion request rejected.');
    }
}
