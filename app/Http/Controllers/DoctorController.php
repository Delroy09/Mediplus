<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;

class DoctorController extends Controller
{
    /**
     * Display doctor dashboard with assigned patients
     */
    public function dashboard()
    {
        $user = (object)[
            'name' => 'Dr. Sarah Smith',
            'email' => 'dr.smith@mediplus.com'
        ];

        // Statistics
        $stats = [
            'active_patients' => 12,
            'appointments_today' => 5,
            'pending_updates' => 3,
            'total_records' => 47
        ];

        // Dummy patients data (will be replaced with actual query)
        // SELECT p.*, u.name FROM patients p 
        // JOIN users u ON p.user_id = u.id
        // JOIN patient_doctor_assignments pda ON p.id = pda.patient_id
        // WHERE pda.doctor_id = ? AND pda.is_active = TRUE
        $patients = [
            (object)[
                'id' => 1,
                'user' => (object)['name' => 'John Doe'],
                'dob' => '1985-05-15',
                'blood_group' => 'A+',
                'status' => 'Admitted',
                'last_visited_date' => '2026-01-15'
            ],
            (object)[
                'id' => 2,
                'user' => (object)['name' => 'Jane Wilson'],
                'dob' => '1992-08-22',
                'blood_group' => 'B+',
                'status' => 'Surgery',
                'last_visited_date' => '2026-01-18'
            ],
            (object)[
                'id' => 3,
                'user' => (object)['name' => 'Mike Johnson'],
                'dob' => '1978-03-10',
                'blood_group' => 'O-',
                'status' => 'Discharged',
                'last_visited_date' => '2026-01-10'
            ]
        ];

        return view('doctor.docdashboard', compact('user', 'stats', 'patients'));
    }

    /**
     * Show list of all assigned patients
     */
    public function patients()
    {
        $user = (object)['name' => 'Dr. Sarah Smith'];

        // Will be replaced with actual database query
        $patients = [];

        return view('doctor.patients', compact('user', 'patients'));
    }

    /**
     * View specific patient details
     */
    public function viewPatient($id)
    {
        $user = (object)['name' => 'Dr. Sarah Smith'];

        // TODO: Fetch patient details
        // $patient = Patient::with('user', 'medicalRecords')->findOrFail($id);

        $patient = (object)[
            'id' => $id,
            'user' => (object)['name' => 'John Doe', 'email' => 'john@example.com'],
            'dob' => '1985-05-15',
            'gender' => 'male',
            'blood_group' => 'A+',
            'mobile_number' => '1234567890',
            'address' => '456 Oak Avenue',
            'status' => 'Admitted',
            'admission_date' => '2026-01-10',
            'last_visited_date' => '2026-01-15'
        ];

        return view('doctor.patient-details', compact('user', 'patient'));
    }

    /**
     * Show form to update patient status
     */
    public function updateStatusForm($id)
    {
        $user = (object)['name' => 'Dr. Sarah Smith'];

        $patient = (object)[
            'id' => $id,
            'user' => (object)['name' => 'John Doe'],
            'status' => 'Admitted'
        ];

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
        $user = (object)['name' => 'Dr. Sarah Smith'];

        // Dummy appointments
        $appointments = [
            (object)[
                'patient_name' => 'John Doe',
                'appointment_date' => '2026-01-20 10:00 AM',
                'type' => 'Checkup',
                'status' => 'scheduled',
                'reason' => 'Regular checkup'
            ],
            (object)[
                'patient_name' => 'Jane Wilson',
                'appointment_date' => '2026-01-20 02:30 PM',
                'type' => 'Follow-up',
                'status' => 'scheduled',
                'reason' => 'Post-surgery follow-up'
            ]
        ];

        return view('doctor.schedule', compact('user', 'appointments'));
    }

    /**
     * Show doctor profile
     */
    public function profile()
    {
        $user = (object)[
            'name' => 'Dr. Sarah Smith',
            'email' => 'dr.smith@mediplus.com'
        ];

        $doctor = (object)[
            'specialization' => 'Cardiology',
            'department' => 'Internal Medicine',
            'license_number' => 'MD123456',
            'qualification' => 'MBBS, MD (Cardiology)',
            'years_of_experience' => 12,
            'consultation_hours' => 'Mon-Fri 9AM-5PM'
        ];

        return view('doctor.profile', compact('user', 'doctor'));
    }

    /**
     * Create medical record for patient
     */
    public function createMedicalRecord($patientId)
    {
        $user = (object)['name' => 'Dr. Sarah Smith'];

        $patient = (object)[
            'id' => $patientId,
            'user' => (object)['name' => 'John Doe']
        ];

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
