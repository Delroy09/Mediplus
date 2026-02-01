@extends('layouts.dashboard_v2')

@section('title', 'My Schedule')

@section('page-title', 'My Schedule')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}">
    <i data-lucide="layout-grid"></i>
    Dashboard
</a>
<a href="{{ route('doctor.patients') }}">
    <i data-lucide="users"></i>
    My Patients
</a>
<a href="{{ route('doctor.schedule') }}" class="active">
    <i data-lucide="calendar"></i>
    My Schedule
</a>
<a href="{{ route('doctor.profile') }}">
    <i data-lucide="user"></i>
    Profile
</a>
@endsection

@section('content')
<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(61, 139, 139, 0.1);">
                <i data-lucide="calendar" style="color: var(--primary-teal);"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $todayAppointments ?? 0 }}</div>
                <div class="stat-label">Today</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1);">
                <i data-lucide="clock" style="color: #3b82f6;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $upcomingAppointments ?? 0 }}</div>
                <div class="stat-label">Upcoming</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.1);">
                <i data-lucide="check-circle" style="color: #22c55e;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $completedAppointments ?? 0 }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1);">
                <i data-lucide="x-circle" style="color: #ef4444;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $cancelledAppointments ?? 0 }}</div>
                <div class="stat-label">Cancelled</div>
            </div>
        </div>
    </div>
</div>

<!-- Today -->
<div class="card-v2 mb-4">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Today's Appointments</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($todaySchedule) && count($todaySchedule) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Patient</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($todaySchedule as $appointment)
                    <tr>
                        <td style="font-weight: 500;">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 32px; height: 32px; background: var(--bg-cream); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 500; font-size: 0.875rem;">
                                    {{ strtoupper(substr($appointment->patient->user->name ?? 'P', 0, 1)) }}
                                </div>
                                <span>{{ $appointment->patient->user->name ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td>{{ $appointment->type ?? 'Checkup' }}</td>
                        <td>
                            <span class="badge-v2 
                                @if($appointment->status === 'Completed') badge-success
                                @elseif($appointment->status === 'In Progress') badge-admitted
                                @elseif($appointment->status === 'Cancelled') badge-danger
                                @else badge-pending
                                @endif">
                                {{ $appointment->status ?? 'Scheduled' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('doctor.patient.view', $appointment->patient_id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View Patient</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">📅</div>
            <p>No appointments scheduled for today.</p>
        </div>
        @endif
    </div>
</div>

<!-- All -->
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">All Appointments</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($appointments) && count($appointments) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Patient</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                        <td>{{ $appointment->patient->user->name ?? 'Unknown' }}</td>
                        <td>{{ $appointment->type ?? 'Checkup' }}</td>
                        <td>
                            <span class="badge-v2 
                                @if($appointment->status === 'Completed') badge-success
                                @elseif($appointment->status === 'In Progress') badge-admitted
                                @elseif($appointment->status === 'Cancelled') badge-danger
                                @else badge-pending
                                @endif">
                                {{ $appointment->status ?? 'Scheduled' }}
                            </span>
                        </td>
                        <td>{{ Str::limit($appointment->notes ?? '-', 30) }}</td>
                        <td>
                            <a href="{{ route('doctor.patient.view', $appointment->patient_id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <p>No appointments found.</p>
        </div>
        @endif
    </div>
</div>

<style>
    .badge-success {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }

    .badge-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .badge-pending {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }
</style>
@endsection