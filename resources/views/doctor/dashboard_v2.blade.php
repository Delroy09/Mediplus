@extends('layouts.dashboard_v2')

@section('title', 'Doctor Dashboard')

@section('page-title', 'Dashboard')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7"></rect>
        <rect x="14" y="3" width="7" height="7"></rect>
        <rect x="14" y="14" width="7" height="7"></rect>
        <rect x="3" y="14" width="7" height="7"></rect>
    </svg>
    Dashboard
</a>
<a href="{{ route('doctor.patients') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    My Patients
</a>
<a href="{{ route('doctor.schedule') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
    </svg>
    My Schedule
</a>
<a href="{{ route('doctor.profile') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    Profile
</a>
@endsection

@section('content')
<!-- Welcome Card -->
<div class="card-v2 mb-4">
    <div class="card-body">
        <h4 style="margin: 0;">Welcome back, <span style="color: var(--primary);">{{ $user->name ?? 'Doctor' }}</span> 👋</h4>
        <p style="color: var(--text-secondary); margin: 0.5rem 0 0;">Here's an overview of your patients and appointments.</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['active_patients'] ?? 12 }}</div>
                    <div class="stat-label">Active Patients</div>
                </div>
                <div class="stat-icon" style="background: #DBEAFE;">👥</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['appointments_today'] ?? 5 }}</div>
                    <div class="stat-label">Today's Appointments</div>
                </div>
                <div class="stat-icon" style="background: #D1FAE5;">📅</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['pending_updates'] ?? 3 }}</div>
                    <div class="stat-label">Pending Updates</div>
                </div>
                <div class="stat-icon" style="background: #FEF3C7;">⏳</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['total_records'] ?? 47 }}</div>
                    <div class="stat-label">Total Records</div>
                </div>
                <div class="stat-icon" style="background: var(--primary-light);">📋</div>
            </div>
        </div>
    </div>
</div>

<!-- Assigned Patients -->
<div class="card-v2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 style="margin: 0; font-weight: 600;">Assigned Patients</h5>
        <a href="{{ route('doctor.patients') }}" class="btn-v2 btn-v2-secondary btn-v2-sm">View All</a>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($patients) && count($patients) > 0)
        <table class="table-v2">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>Blood Group</th>
                    <th>Status</th>
                    <th>Last Visit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 36px; height: 36px; background: var(--bg-cream); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                {{ strtoupper(substr($patient->user->name ?? 'P', 0, 1)) }}
                            </div>
                            <span style="font-weight: 500;">{{ $patient->user->name ?? 'Patient Name' }}</span>
                        </div>
                    </td>
                    <td>{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->age : 'N/A' }}</td>
                    <td>{{ $patient->blood_group ?? 'N/A' }}</td>
                    <td>
                        <span class="badge-v2 
                            @if($patient->status === 'Admitted') badge-admitted
                            @elseif($patient->status === 'Surgery') badge-surgery
                            @else badge-discharged
                            @endif">
                            {{ $patient->status }}
                        </span>
                    </td>
                    <td>{{ $patient->last_visited_date ?? 'N/A' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('doctor.patient.view', $patient->id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View</a>
                            <a href="{{ route('doctor.patient.update-status', $patient->id) }}" class="btn-v2 btn-v2-secondary btn-v2-sm">Update</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">👥</div>
            <p>No patients assigned yet.</p>
            <small style="color: var(--text-muted);">Contact the IT administrator for patient assignments.</small>
        </div>
        @endif
    </div>
</div>
@endsection