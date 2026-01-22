@extends('layouts.dashboard-layout')

@section('title', 'Profile')

@section('page-title', 'Profile')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}">Dashboard</a>
<a href="{{ route('doctor.patients') }}">My Patients</a>
<a href="{{ route('doctor.schedule') }}">My Schedule</a>
<a href="{{ route('doctor.profile') }}" class="active">Profile</a>
@endsection

@section('content')
<div class="content-box">
    <h5 style="text-align: center; margin-bottom: 25px; font-weight: 600;">Doctor Profile</h5>

    <div class="info-row">
        <strong>Full Name:</strong> &nbsp; {{ $user->name ?? 'Dr. Name' }}
    </div>

    <div class="info-row">
        <strong>Email Address:</strong> &nbsp; {{ $user->email ?? 'doctor@example.com' }}
    </div>

    <div class="info-row">
        <strong>Specialization:</strong> &nbsp; {{ $doctor->specialization ?? 'N/A' }}
    </div>

    <div class="info-row">
        <strong>Department:</strong> &nbsp; {{ $doctor->department ?? 'N/A' }}
    </div>

    <div class="info-row">
        <strong>License Number:</strong> &nbsp; {{ $doctor->license_number ?? 'N/A' }}
    </div>

    <div class="info-row">
        <strong>Qualification:</strong> &nbsp; {{ $doctor->qualification ?? 'N/A' }}
    </div>

    <div class="info-row">
        <strong>Years of Experience:</strong> &nbsp; {{ $doctor->years_of_experience ?? 'N/A' }}
    </div>

    <div class="info-row">
        <strong>Consultation Hours:</strong> &nbsp; {{ $doctor->consultation_hours ?? 'N/A' }}
    </div>
</div>
@endsection