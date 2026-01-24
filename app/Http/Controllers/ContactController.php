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
            'email' => 'required|email|max:255|unique:account_requests,email',
            'mobile_number' => 'required|digits:10',
            'message' => 'nullable|string|max:1000'
        ]);

        // 2. Save to 'account_requests' table
        \App\Models\AccountRequest::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile_number' => $validated['mobile_number'],
            'message' => $validated['message'],
            'status' => 'pending',
            'requested_role' => 'patient',
        ]);

        // 3. Redirect with success message
        return redirect()->route('contact.show')->with('success', 'Your request has been submitted successfully. You will be notified via email once approved.');
    }
}
