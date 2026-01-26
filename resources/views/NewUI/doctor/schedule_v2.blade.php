@extends('NewUI.layouts.dashboard_v2')

@section('title', 'My Schedule')

@section('page-title', 'My Schedule')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard.v2') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7"></rect>
        <rect x="14" y="3" width="7" height="7"></rect>
        <rect x="14" y="14" width="7" height="7"></rect>
        <rect x="3" y="14" width="7" height="7"></rect>
    </svg>
    Dashboard
</a>
<a href="{{ route('doctor.patients.v2') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    My Patients
</a>
<a href="{{ route('doctor.schedule.v2') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
    </svg>
    My Schedule
</a>
<a href="{{ route('doctor.profile.v2') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    Profile
</a>
@endsection

@section('content')
<!-- Schedule Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(61, 139, 139, 0.1);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary-teal)" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
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
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
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
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
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
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $cancelledAppointments ?? 0 }}</div>
                <div class="stat-label">Cancelled</div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Appointments -->
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
                            <a href="{{ route('doctor.patient.view.v2', $appointment->patient_id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View Patient</a>
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

<!-- All Appointments -->
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
                            <a href="{{ route('doctor.patient.view.v2', $appointment->patient_id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View</a>
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