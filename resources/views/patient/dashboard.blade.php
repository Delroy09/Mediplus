@extends('layouts.dashboard-layout')

@section('title', 'Patient Dashboard')

@section('page-title', 'Dashboard')

@section('sidebar-menu')
<a href="{{ route('patient.dashboard') }}" class="active">Dashboard</a>
<a href="{{ route('patient.profile') }}">Edit Profile</a>
<a href="{{ route('patient.schedule') }}">My Schedule</a>
<a href="{{ route('patient.manage') }}">Manage Account</a>
@endsection

@section('content')
<div class="content-box">
    <div class="info-row">
        <strong>Full Name:</strong> &nbsp; {{ $user->name ?? 'Nash Dsouza' }}
    </div>

    <div class="info-row">
        <strong>DOB:</strong> &nbsp; {{ $patient->dob ?? '31/12/2003' }}
    </div>

    <div class="info-row">
        <strong>Sex:</strong> &nbsp; {{ ucfirst($patient->gender ?? 'Male') }}
    </div>

    <div class="info-row">
        <strong>Age:</strong> &nbsp;
        @if(isset($patient->dob))
        {{ \Carbon\Carbon::parse($patient->dob)->age }}
        @else
        23
        @endif
    </div>

    <div class="info-row">
        <strong>Recent Surgery?:</strong> &nbsp; {{ $patient->last_visited_date ?? '31/12/2003' }}
    </div>

    <div class="info-row">
        <strong>Status:</strong> &nbsp;
        <span class="badge 
            @if($patient->status ?? 'Discharged' === 'Admitted') bg-success
            @elseif($patient->status ?? 'Discharged' === 'Surgery') bg-warning
            @else bg-info
            @endif">
            {{ $patient->status ?? 'Discharged' }}
        </span>
    </div>

    <div class="info-row">
        <strong>Email Address:</strong> &nbsp; {{ $user->email ?? 'nds@gmail.com' }}
    </div>
</div>
@endsection