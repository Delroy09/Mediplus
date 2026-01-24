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
}
