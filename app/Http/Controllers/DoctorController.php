<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Appointment;
use App\Models\MedicalRecord;

class DoctorController extends Controller
{
    /**
     * Display doctor dashboard with assigned patients
     */
    public function dashboard()
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->with('user')->first();

        if (!$doctor) {
            abort(404, 'Doctor record not found');
        }

        // Get assigned patients
        $patients = $doctor->patients()->wherePivot('is_active', true)->with('user')->get();

        // Statistics
        $stats = [
            'active_patients' => $patients->where('status', '!=', 'Discharged')->count(),
            'appointments_today' => Appointment::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', today())
                ->where('status', 'scheduled')
                ->count(),
            'pending_updates' => $patients->where('status', 'Admitted')->count(),
            'total_records' => MedicalRecord::where('doctor_id', $doctor->id)->count()
        ];

        return view('doctor.docdashboard', compact('user', 'stats', 'patients'));
    }

    /**
     * Show list of all assigned patients
     */
    public function patients()
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->with('user')->first();

        if (!$doctor) {
            abort(404, 'Doctor not found');
        }

        $user = $doctor->user;
        $patients = $doctor->patients()->with('user')->get();

        return view('doctor.patients', compact('user', 'patients'));
    }

    /**
     * View specific patient details
     */
    public function viewPatient($id)
    {
        $doctor = Doctor::with('user')->find(1);
        $user = $doctor->user;

        $patient = Patient::with('user')->findOrFail($id);
        $medicalRecords = MedicalRecord::where('patient_id', $id)
            ->with(['doctor.user'])
            ->orderBy('visit_date', 'desc')
            ->get();

        return view('doctor.patient-details', compact('user', 'patient', 'medicalRecords'));
    }

    /**
     * Show form to update patient status
     */
    public function updateStatusForm($id)
    {
        $doctor = Doctor::with('user')->find(1);
        $user = $doctor->user;

        $patient = Patient::with('user')->findOrFail($id);

        return view('doctor.update-status', compact('user', 'patient'));
    }

    /**
     * Update patient status
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Admitted,Surgery,Discharged',
            'notes' => 'nullable|string|max:500'
        ]);

        // TODO: Update patient status and create log entry
        // Patient::findOrFail($id)->update(['status' => $validated['status']]);
        // PatientStatusLog::create([...]);

        return redirect()->route('doctor.dashboard')->with('success', 'Patient status updated successfully!');
    }

    /**
     * Show doctor's schedule (appointments)
     */
    public function schedule()
    {
        $doctor = Doctor::with('user')->find(1);
        $user = $doctor->user;

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with(['patient.user'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('doctor.schedule', compact('user', 'appointments'));
    }

    /**
     * Show doctor profile
     */
    public function profile()
    {
        $doctor = Doctor::with('user')->find(1);

        if (!$doctor) {
            abort(404, 'Doctor not found');
        }

        $user = $doctor->user;

        return view('doctor.profile', compact('user', 'doctor'));
    }

    /**
     * Create medical record for patient
     */
    public function createMedicalRecord($patientId)
    {
        $doctor = Doctor::with('user')->find(1);
        $user = $doctor->user;

        $patient = Patient::with('user')->findOrFail($patientId);

        return view('doctor.create-medical-record', compact('user', 'patient'));
    }

    /**
     * Store medical record
     */
    public function storeMedicalRecord(Request $request, $patientId)
    {
        $validated = $request->validate([
            'visit_date' => 'required|date|before_or_equal:today',
            'symptoms' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        // TODO: Create medical record
        // MedicalRecord::create([
        //     'patient_id' => $patientId,
        //     'doctor_id' => Auth::user()->doctor->id,
        //     ...$validated
        // ]);

        return redirect()->route('doctor.patient.view', $patientId)->with('success', 'Medical record added successfully!');
    }

    // =============================================
    // V2 Methods (New UI - Same functionality)
    // =============================================

    /**
     * V2 Dashboard
     */
    public function dashboardV2()
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->with('user')->first();

        if (!$doctor) {
            abort(404, 'Doctor record not found');
        }

        $patients = $doctor->patients()->wherePivot('is_active', true)->with('user')->get();

        $stats = [
            'active_patients' => $patients->where('status', '!=', 'Discharged')->count(),
            'appointments_today' => Appointment::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', today())
                ->where('status', 'scheduled')
                ->count(),
            'pending_updates' => $patients->where('status', 'Admitted')->count(),
            'total_records' => MedicalRecord::where('doctor_id', $doctor->id)->count()
        ];

        return view('doctor.dashboard_v2', compact('user', 'stats', 'patients'));
    }

    /**
     * V2 Patients List
     */
    public function patientsV2()
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->with('user')->first();

        if (!$doctor) {
            abort(404, 'Doctor not found');
        }

        $user = $doctor->user;
        $patients = $doctor->patients()->with('user')->get();

        return view('doctor.patients_v2', compact('user', 'patients'));
    }

    /**
     * V2 View Patient
     */
    public function viewPatientV2($id)
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->with('user')->first();

        if (!$doctor) {
            abort(404, 'Doctor record not found');
        }

        $patient = Patient::with('user')->findOrFail($id);
        $medicalRecords = MedicalRecord::where('patient_id', $id)
            ->with(['doctor.user'])
            ->orderBy('visit_date', 'desc')
            ->get();

        return view('doctor.patient-details_v2', compact('user', 'patient', 'medicalRecords'));
    }

    /**
     * V2 Update Status Form
     */
    public function updateStatusFormV2($id)
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->with('user')->first();

        if (!$doctor) {
            abort(404, 'Doctor record not found');
        }

        $patient = Patient::with('user')->findOrFail($id);

        return view('doctor.update-status_v2', compact('user', 'patient'));
    }

    /**
     * V2 Create Medical Record Form
     */
    public function createMedicalRecordV2($patientId)
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->with('user')->first();

        if (!$doctor) {
            abort(404, 'Doctor record not found');
        }

        $patient = Patient::with('user')->findOrFail($patientId);

        return view('doctor.create-medical-record_v2', compact('user', 'patient'));
    }

    /**
     * V2 Schedule
     */
    public function scheduleV2()
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->with('user')->first();

        if (!$doctor) {
            abort(404, 'Doctor record not found');
        }

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with(['patient.user'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        $todaySchedule = $appointments->filter(function ($apt) {
            return $apt->appointment_date && $apt->appointment_date->isToday();
        });

        $todayAppointments = $todaySchedule->count();
        $upcomingAppointments = $appointments->filter(function ($apt) {
            return $apt->appointment_date && $apt->appointment_date->isFuture();
        })->count();
        $completedAppointments = $appointments->where('status', 'completed')->count();
        $cancelledAppointments = $appointments->where('status', 'cancelled')->count();

        return view('doctor.schedule_v2', compact(
            'user',
            'appointments',
            'todaySchedule',
            'todayAppointments',
            'upcomingAppointments',
            'completedAppointments',
            'cancelledAppointments'
        ));
    }

    /**
     * V2 Profile
     */
    public function profileV2()
    {
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->with('user')->first();

        if (!$doctor) {
            abort(404, 'Doctor record not found');
        }

        $totalPatients = $doctor->patients()->count();
        $activePatients = $doctor->patients()->where('status', '!=', 'Discharged')->count();
        $totalRecords = MedicalRecord::where('doctor_id', $doctor->id)->count();
        $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', '>=', now())
            ->count();

        return view('doctor.profile_v2', compact(
            'user',
            'doctor',
            'totalPatients',
            'activePatients',
            'totalRecords',
            'upcomingAppointments'
        ));
    }

    /**
     * V2 Update patient status (redirects to V2)
     */
    public function updateStatusV2(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Admitted,Surgery,Discharged',
            'notes' => 'nullable|string|max:500',
            'last_visited_date' => 'nullable|date'
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update([
            'status' => $validated['status'],
            'last_visited_date' => $validated['last_visited_date'] ?? $patient->last_visited_date
        ]);

        return redirect()->route('doctor.patient.view', $id)->with('success', 'Patient status updated successfully!');
    }

    /**
     * V2 Store medical record (redirects to V2)
     */
    public function storeMedicalRecordV2(Request $request, $patientId)
    {
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'medications' => 'nullable|string',
            'blood_pressure' => 'nullable|string',
            'temperature' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'follow_up_date' => 'nullable|date'
        ]);

        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->first();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor record not found.');
        }

        MedicalRecord::create([
            'patient_id' => $patientId,
            'doctor_id' => $doctor->id,
            'visit_date' => now(),
            'diagnosis' => $validated['diagnosis'],
            'treatment' => $validated['treatment'],
            'medications' => $validated['medications'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('doctor.patient.view', $patientId)->with('success', 'Medical record added successfully!');
    }
}
