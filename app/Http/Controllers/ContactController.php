<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return view('contact');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function submit(Patient $patient)
    {
        $patient->validate([

        'name'=>'required',
        'email'=>'required|email',
        'mobile'=>'required',



        ]);


        AccountRequest::create($request->all());

        return back()->with('success','Form Submit Success, the IT department will be working on it!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
