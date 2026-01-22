@extends('layouts.dashboard-layout')

@section('title', 'Create Medical Record')

@section('page-title', 'Create Medical Record')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}">Dashboard</a>
<a href="{{ route('doctor.patients') }}">My Patients</a>
<a href="{{ route('doctor.schedule') }}">My Schedule</a>
<a href="{{ route('doctor.profile') }}">Profile</a>
@endsection

@section('content')
<div class="content-box">
    <h5 style="margin-bottom: 25px; font-weight: 600;">Add Medical Record for {{ $patient->user->name ?? 'Patient' }}</h5>

    <form action="{{ route('doctor.patient.store-record', $patient->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="visit_date" style="font-weight: 600; margin-bottom: 8px;">Visit Date:</label>
            <input type="datetime-local" name="visit_date" id="visit_date" class="form-control" style="background: white; border: 1px solid #ddd; padding: 8px; border-radius: 4px;" required>
        </div>

        <div class="mb-3">
            <label for="symptoms" style="font-weight: 600; margin-bottom: 8px;">Symptoms:</label>
            <textarea name="symptoms" id="symptoms" class="form-control" rows="3" style="background: white; border: 1px solid #ddd; padding: 8px; border-radius: 4px;" placeholder="Enter patient symptoms..." required></textarea>
        </div>

        <div class="mb-3">
            <label for="diagnosis" style="font-weight: 600; margin-bottom: 8px;">Diagnosis:</label>
            <textarea name="diagnosis" id="diagnosis" class="form-control" rows="3" style="background: white; border: 1px solid #ddd; padding: 8px; border-radius: 4px;" placeholder="Enter diagnosis..." required></textarea>
        </div>

        <div class="mb-3">
            <label for="treatment" style="font-weight: 600; margin-bottom: 8px;">Treatment:</label>
            <textarea name="treatment" id="treatment" class="form-control" rows="3" style="background: white; border: 1px solid #ddd; padding: 8px; border-radius: 4px;" placeholder="Enter treatment plan..." required></textarea>
        </div>

        <div class="mb-3">
            <label for="notes" style="font-weight: 600; margin-bottom: 8px;">Additional Notes (Optional):</label>
            <textarea name="notes" id="notes" class="form-control" rows="2" style="background: white; border: 1px solid #ddd; padding: 8px; border-radius: 4px;" placeholder="Any additional notes..."></textarea>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn" style="background: #2b5797; color: white; padding: 10px 30px; border-radius: 5px;">Save Medical Record</button>
            <a href="{{ route('doctor.patient.view', $patient->id) }}" class="btn btn-secondary" style="padding: 10px 30px; border-radius: 5px;">Cancel</a>
        </div>
    </form>
</div>
@endsection