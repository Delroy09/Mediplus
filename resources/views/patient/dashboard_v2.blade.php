@extends('layouts.dashboard_v2')

@section('title', 'Patient Dashboard')

@section('page-title', 'Dashboard')

@section('sidebar-menu')
<a href="{{ route('patient.dashboard') }}" class="active">
    <i data-lucide="layout-grid"></i>
    Dashboard
</a>
<a href="{{ route('patient.profile') }}">
    <i data-lucide="user"></i>
    Edit Profile
</a>
<a href="{{ route('patient.schedule') }}">
    <i data-lucide="calendar"></i>
    My Schedule
</a>
<a href="{{ route('patient.manage') }}">
    <i data-lucide="settings"></i>
    Manage Account
</a>
@endsection

@section('content')
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Patient Information</h5>
    </div>
    <div class="card-body">
        <div class="info-row-v2">
            <span class="label">Full Name</span>
            <span class="value">{{ $user->name ?? 'Nash Dsouza' }}</span>
        </div>
        <div class="info-row-v2">
            <span class="label">Date of Birth</span>
            <span class="value">{{ $patient->dob ?? '31/12/2003' }}</span>
        </div>
        <div class="info-row-v2">
            <span class="label">Sex</span>
            <span class="value">{{ ucfirst($patient->gender ?? 'Male') }}</span>
        </div>
        <div class="info-row-v2">
            <span class="label">Age</span>
            <span class="value">
                @if(isset($patient->dob))
                {{ \Carbon\Carbon::parse($patient->dob)->age }} years
                @else
                23 years
                @endif
            </span>
        </div>
        <div class="info-row-v2">
            <span class="label">Last Visit</span>
            <span class="value">{{ $patient->last_visited_date ?? '31/12/2003' }}</span>
        </div>
        <div class="info-row-v2">
            <span class="label">Status</span>
            <span class="value">
                <span class="badge-v2 
                    @if(($patient->status ?? 'Discharged') === 'Admitted') badge-admitted
                    @elseif(($patient->status ?? 'Discharged') === 'Surgery') badge-surgery
                    @else badge-discharged
                    @endif">
                    {{ $patient->status ?? 'Discharged' }}
                </span>
            </span>
        </div>
        <div class="info-row-v2">
            <span class="label">Email Address</span>
            <span class="value">{{ $user->email ?? 'nds@gmail.com' }}</span>
        </div>
    </div>
</div>

<div class="card-v2 mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 style="margin: 0; font-weight: 600;">Assigned Doctors</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($assignedDoctors) && $assignedDoctors->count() > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Doctor Name</th>
                        <th>Specialization</th>
                        <th>Department</th>
                        <th>Consultation Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignedDoctors as $doctor)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; background: var(--primary-light); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary);">👨‍⚕️</div>
                                <span style="font-weight: 500;">{{ $doctor->user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $doctor->specialization }}</td>
                        <td>{{ $doctor->department }}</td>
                        <td>{{ $doctor->consultation_hours }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">👨‍⚕️</div>
            <p>No doctors assigned yet.</p>
            <small style="color: var(--text-muted);">A doctor will be assigned to you soon.</small>
        </div>
        @endif
    </div>
</div>
@endsection