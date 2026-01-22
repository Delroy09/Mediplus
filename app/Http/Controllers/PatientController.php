<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\User;
use App\Models\Appointment;

class PatientController extends Controller
{
    /**
     * Display patient dashboard
     */
    public function dashboard()
    {
        // Temporary: Using first patient for testing (ID = 1)
        $patient = Patient::with('user')->find(1);

        if (!$patient) {
            abort(404, 'Patient not found');
        }

        $user = $patient->user;

        return view('patient.dashboard', compact('user', 'patient'));
    }

    /**
     * Show edit profile page
     */
    public function profile()
    {
        // Temporary: Using first patient for testing (ID = 1)
        $patient = Patient::with('user')->find(1);

        if (!$patient) {
            abort(404, 'Patient not found');
        }

        $user = $patient->user;

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
        // Temporary: Using first patient for testing (ID = 1)
        $patient = Patient::with('user')->find(1);

        if (!$patient) {
            abort(404, 'Patient not found');
        }

        $user = $patient->user;
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor.user'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('patient.schedule', compact('user', 'appointments'));
    }

    /**
     * Show manage account page (delete request)
     */
    public function manage()
    {
        // Temporary: Using first patient for testing (ID = 1)
        $patient = Patient::with('user')->find(1);

        if (!$patient) {
            abort(404, 'Patient not found');
        }

        $user = $patient->user;

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
