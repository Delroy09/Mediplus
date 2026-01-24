<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingRequests = AccountRequest::where('status', 'pending')->get();
        $recentRequests = AccountRequest::whereIn('status', ['approved', 'rejected'])
            ->orderBy('reviewed_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('pendingRequests', 'recentRequests'));
    }

    public function approveRequest($id)
    {
        $request = AccountRequest::findOrFail($id);

        if ($request->status !== 'pending') {
            return redirect()->back()->with('error', 'Request already processed.');
        }

        DB::transaction(function () use ($request) {
            // Create user account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password'), // Default password
                'role' => $request->requested_role,
            ]);

            // Create patient or doctor record
            if ($request->requested_role === 'patient') {
                $patient = Patient::create([
                    'user_id' => $user->id,
                    'mobile_number' => $request->mobile_number,
                    'blood_group' => 'O+', // Default, user can update
                    'dob' => '2000-01-01', // Default, user can update
                    'gender' => 'male', // Default, user can update
                    'address' => 'Address not provided',
                    'status' => 'Admitted',
                ]);

                // Auto-assign to first available doctor (Dr. Priya Sharma - Cardiology)
                \App\Models\PatientDoctorAssignment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => 1, // Default to first doctor
                    'assigned_date' => now(),
                    'is_active' => true,
                    'assigned_by' => 1, // Admin
                    'notes' => 'Auto-assigned on account approval',
                ]);
            }

            // Update request status
            $request->update([
                'status' => 'approved',
                'reviewed_by' => 1, // Hardcoded admin ID for now
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
            'reviewed_by' => 1, // Hardcoded admin ID for now
            'reviewed_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Account request rejected.');
    }
}
