@extends('layouts.dashboard_v2')

@section('title', 'Doctor Dashboard')

@section('page-title', 'Dashboard')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}" class="active">
    <i data-lucide="layout-grid"></i>
    Dashboard
</a>
<a href="{{ route('doctor.patients') }}">
    <i data-lucide="users"></i>
    My Patients
</a>
<a href="{{ route('doctor.schedule') }}">
    <i data-lucide="calendar"></i>
    My Schedule
</a>
<a href="{{ route('doctor.profile') }}">
    <i data-lucide="user"></i>
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
    <div class="col-12 col-sm-6 col-lg-3">
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
    <div class="col-12 col-sm-6 col-lg-3">
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
    <div class="col-12 col-sm-6 col-lg-3">
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
    <div class="col-12 col-sm-6 col-lg-3">
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