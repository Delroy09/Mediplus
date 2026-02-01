@extends('layouts.dashboard_v2')

@section('title', 'My Schedule')

@section('page-title', 'My Schedule')

@section('sidebar-menu')
<a href="{{ route('patient.dashboard') }}">
    <i data-lucide="layout-grid"></i>
    Dashboard
</a>
<a href="{{ route('patient.profile') }}">
    <i data-lucide="user"></i>
    Edit Profile
</a>
<a href="{{ route('patient.schedule') }}" class="active">
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
        <h5 style="margin: 0; font-weight: 600;">Appointment History</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($appointments) && count($appointments) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Doctor</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y, h:i A') }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="font-weight: 500;">{{ $appointment->doctor->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ ucfirst($appointment->appointment_type) }}</td>
                        <td>
                            <span class="badge-v2 
                            @if($appointment->status === 'scheduled') badge-primary
                            @elseif($appointment->status === 'completed') badge-success
                            @elseif($appointment->status === 'cancelled') badge-danger
                            @else badge-secondary
                            @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td>{{ $appointment->reason ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">📅</div>
            <p>No appointments scheduled yet.</p>
            <small style="color: var(--text-muted);">Contact your assigned doctor to schedule an appointment.</small>
        </div>
        @endif
    </div>
</div>
@endsection