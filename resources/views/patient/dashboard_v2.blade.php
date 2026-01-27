@extends('layouts.dashboard_v2')

@section('title', 'Patient Dashboard')

@section('page-title', 'Dashboard')

@section('sidebar-menu')
<a href="{{ route('patient.dashboard') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7"></rect>
        <rect x="14" y="3" width="7" height="7"></rect>
        <rect x="14" y="14" width="7" height="7"></rect>
        <rect x="3" y="14" width="7" height="7"></rect>
    </svg>
    Dashboard
</a>
<a href="{{ route('patient.profile') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    Edit Profile
</a>
<a href="{{ route('patient.schedule') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
    </svg>
    My Schedule
</a>
<a href="{{ route('patient.manage') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="3"></circle>
        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
    </svg>
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
                                <span style="font-weight: 500;">Dr. {{ $doctor->user->name }}</span>
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
