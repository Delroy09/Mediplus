<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\User;

class PatientController extends Controller
{
    /**
     * Display patient dashboard
     */
    public function dashboard()
    {
        // Get current authenticated user (will be implemented with auth)
        // For now, using dummy data
        $user = (object)[
            'name' => 'Nash Dsouza',
            'email' => 'nds@gmail.com'
        ];

        $patient = (object)[
            'dob' => '2003-12-31',
            'gender' => 'male',
            'blood_group' => 'O+',
            'status' => 'Discharged',
            'last_surgery_date' => '31/12/2003'
        ];

        return view('patient.dashboard', compact('user', 'patient'));
    }

    /**
     * Show edit profile page
     */
    public function profile()
    {
        $user = (object)[
            'name' => 'Nash Dsouza',
            'email' => 'nds@gmail.com'
        ];

        $patient = (object)[
            'dob' => '2003-12-31',
            'gender' => 'male',
            'blood_group' => 'O+',
            'mobile_number' => '1234567890',
            'address' => '123 Main Street, City',
            'status' => 'Discharged',
            'last_surgery_date' => '31/12/2003'
        ];

        return view('patient.profile', compact('user', 'patient'));
    }

    /**
     * Update patient profile (mobile/address only)
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'mobile_number' => 'required|digits:10',
            'address' => 'required|string|max:500'
        ]);

        // TODO: Update patient record in database
        // Patient::where('user_id', Auth::id())->update($validated);

        return redirect()->route('patient.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show patient schedule (appointments)
     */
    public function schedule()
    {
        $user = (object)['name' => 'Nash Dsouza'];

        // Dummy appointments data
        $appointments = [
            (object)[
                'doctor_name' => 'Dr. Smith',
                'specialization' => 'Cardiology',
                'appointment_date' => '2026-01-25 10:00 AM',
                'type' => 'Checkup',
                'status' => 'scheduled'
            ],
            (object)[
                'doctor_name' => 'Dr. Johnson',
                'specialization' => 'General Medicine',
                'appointment_date' => '2026-02-01 02:30 PM',
                'type' => 'Follow-up',
                'status' => 'scheduled'
            ]
        ];

        return view('patient.schedule', compact('user', 'appointments'));
    }

    /**
     * Show manage account page (delete request)
     */
    public function manage()
    {
        $user = (object)[
            'name' => 'Nash Dsouza',
            'email' => 'nds@gmail.com'
        ];

        $patient = (object)[
            'status' => 'Discharged'
        ];

        return view('patient.manage', compact('user', 'patient'));
    }

    /**
     * Request account deletion
     */
    public function requestDeletion(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        // TODO: Create deletion request in database
        // DeletionRequest::create([
        //     'user_id' => Auth::id(),
        //     'reason' => $validated['reason'],
        //     'status' => 'pending'
        // ]);

        return redirect()->route('patient.manage')->with('success', 'Deletion request submitted. IT admin will review shortly.');
    }

    // Legacy CRUD methods (kept for compatibility)
    public function index() {}
    public function create() {}
    public function store(Request $request) {}
    public function show(Patient $patient) {}
    public function edit(Patient $patient) {}
    public function update(Request $request, Patient $patient) {}
    public function destroy(Patient $patient) {}
}
