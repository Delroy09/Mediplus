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
}
