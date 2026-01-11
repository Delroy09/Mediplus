<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the contact/request account form.
     */
    public function show()
    {
        return view('contact');
    }

    /**
     * Handle the contact form submission.
     */
    public function submit(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_number' => 'required|digits:10',
            'message' => 'nullable|string'
        ]);

        // 2. TODO: Save to 'account_requests' table.
        // For now, we simulate success so the frontend can be tested.
        
        return back()->with('success', 'Your request has been submitted successfully! IT Admin will review it shortly.');
    }
}
