<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DeletionRequest;

class PatientController extends Controller
{
    /**
     * Display patient dashboard
     */
    public function dashboard()
    {
        // Get logged-in user's patient record
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->with(['user', 'doctors.user'])->first();

        if (!$patient) {
            abort(404, 'Patient record not found');
        }

        // Get assigned doctors
        $assignedDoctors = $patient->doctors()->wherePivot('is_active', true)->with('user')->get();

        return view('patient.dashboard', compact('user', 'patient', 'assignedDoctors'));
    }

    /**
     * Show edit profile page
     */
    public function profile()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->with('user')->first();

        if (!$patient) {
            abort(404, 'Patient record not found');
        }

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
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->with('user')->first();

        if (!$patient) {
            abort(404, 'Patient record not found');
        }

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

    // =============================================
    // V2 Methods (New UI - Same functionality)
    // =============================================

    /**
     * V2 Dashboard
     */
    public function dashboardV2()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->with(['user', 'doctors.user'])->first();

        if (!$patient) {
            abort(404, 'Patient record not found');
        }

        $assignedDoctors = $patient->doctors()->wherePivot('is_active', true)->with('user')->get();

        return view('patient.dashboard_v2', compact('user', 'patient', 'assignedDoctors'));
    }

    /**
     * V2 Profile
     */
    public function profileV2()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->with('user')->first();

        if (!$patient) {
            abort(404, 'Patient record not found');
        }

        return view('patient.profile_v2', compact('user', 'patient'));
    }

    /**
     * V2 Schedule
     */
    public function scheduleV2()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->with('user')->first();

        if (!$patient) {
            abort(404, 'Patient record not found');
        }
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor.user'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('patient.schedule_v2', compact('user', 'appointments'));
    }

    /**
     * V2 Manage
     */
    public function manageV2()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->with('user')->first();

        if (!$patient) {
            abort(404, 'Patient record not found');
        }

        return view('patient.manage_v2', compact('user', 'patient'));
    }

    /**
     * V2 Update Profile - Redirects to V2 profile page
     */
    public function updateProfileV2(Request $request)
    {
        $validated = $request->validate([
            'mobile_number' => 'required|digits:10',
            'address' => 'required|string|max:500'
        ]);

        $patient = Patient::where('user_id', Auth::id())->first();
        if ($patient) {
            $patient->update([
                'mobile_number' => $validated['mobile_number'],
                'address' => $validated['address']
            ]);
        }

        return redirect()->route('patient.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * V2 Request Deletion - Redirects to V2 manage page
     */
    public function requestDeletionV2(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->first();

        if (!$patient) {
            return redirect()->route('patient.manage')->withErrors(['error' => 'Patient record not found.']);
        }

        // Only allow deletion request if patient status is 'Discharged'
        if ($patient->status !== 'Discharged') {
            return redirect()->route('patient.manage')->withErrors(['error' => 'You can only request account deletion when your status is Discharged.']);
        }

        // Check if there's already a pending request
        $existingRequest = DeletionRequest::where('patient_id', $patient->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return redirect()->route('patient.manage')->withErrors(['error' => 'You already have a pending deletion request.']);
        }

        // Create deletion request
        DeletionRequest::create([
            'patient_id' => $patient->id,
            'reason' => $validated['reason'],
            'status' => 'pending'
        ]);

        return redirect()->route('patient.manage')->with('success', 'Deletion request submitted successfully. An admin will review your request shortly.');
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
