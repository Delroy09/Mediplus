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
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="info-card">
            <div class="info-row">
                <div class="info-label">Full Name:</div>
                <div class="info-value readonly">{{ $user->name ?? 'Nash Dsouza' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">DOB:</div>
                <div class="info-value readonly">{{ $patient->dob ?? '31/12/2003' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Sex:</div>
                <div class="info-value readonly">{{ ucfirst($patient->gender ?? 'Male') }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Age:</div>
                <div class="info-value readonly">
                    @if(isset($patient->dob))
                    {{ \Carbon\Carbon::parse($patient->dob)->age }}
                    @else
                    23
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Recent Surgery?:</div>
                <div class="info-value readonly">{{ $patient->last_surgery_date ?? '31/12/2003' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value readonly">
                    <span class="badge 
                        @if($patient->status ?? 'Discharged' === 'Admitted') bg-success
                        @elseif($patient->status ?? 'Discharged' === 'Surgery') bg-warning
                        @else bg-info
                        @endif">
                        {{ $patient->status ?? 'Discharged' }}
                    </span>
                    @if(($patient->status ?? 'Discharged') === 'Admitted')
                    / Admitted / Operation in progress
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Email Address:</div>
                <div class="info-value readonly">{{ $user->email ?? 'nds@gmail.com' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection