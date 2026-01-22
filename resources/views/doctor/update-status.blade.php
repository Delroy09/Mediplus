@extends('layouts.dashboard-layout')

@section('title', 'Update Patient Status')

@section('page-title', 'Update Patient Status')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}">Dashboard</a>
<a href="{{ route('doctor.patients') }}">My Patients</a>
<a href="{{ route('doctor.schedule') }}">My Schedule</a>
<a href="{{ route('doctor.profile') }}">Profile</a>
@endsection

@section('content')
<div class="content-box">
    <h5 style="margin-bottom: 25px; font-weight: 600;">Update Status for {{ $patient->user->name ?? 'Patient' }}</h5>

    <form action="{{ route('doctor.patient.update-status.submit', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="info-row" style="display: block;">
            <strong>Current Status:</strong> &nbsp;
            <span class="badge 
                @if($patient->status === 'Admitted') bg-success
                @elseif($patient->status === 'Surgery') bg-warning
                @else bg-info
                @endif">
                {{ $patient->status }}
            </span>
        </div>

        <br>

        <div class="mb-3">
            <label for="status" style="font-weight: 600; margin-bottom: 8px;">New Status:</label>
            <select name="status" id="status" class="form-select" style="background: white; border: 1px solid #ddd; padding: 8px; border-radius: 4px;" required>
                <option value="">-- Select Status --</option>
                <option value="Admitted">Admitted</option>
                <option value="Surgery">Surgery</option>
                <option value="Discharged">Discharged</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="reason" style="font-weight: 600; margin-bottom: 8px;">Reason for Status Change:</label>
            <textarea name="reason" id="reason" class="form-control" rows="4" style="background: white; border: 1px solid #ddd; padding: 8px; border-radius: 4px;" placeholder="Enter reason for status change..." required></textarea>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn" style="background: #2b5797; color: white; padding: 10px 30px; border-radius: 5px;">Update Status</button>
            <a href="{{ route('doctor.patient.view', $patient->id) }}" class="btn btn-secondary" style="padding: 10px 30px; border-radius: 5px;">Cancel</a>
        </div>
    </form>
</div>
@endsection