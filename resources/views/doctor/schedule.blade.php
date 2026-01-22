@extends('layouts.dashboard-layout')

@section('title', 'My Schedule')

@section('page-title', 'My Schedule')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}">Dashboard</a>
<a href="{{ route('doctor.patients') }}">My Patients</a>
<a href="{{ route('doctor.schedule') }}" class="active">My Schedule</a>
<a href="{{ route('doctor.profile') }}">Profile</a>
@endsection

@section('content')
<div class="content-box">
    <h5 style="margin-bottom: 20px; font-weight: 600;">Upcoming Appointments</h5>

    <div class="table-responsive">
        <table class="table table-hover bg-white" style="border-radius: 8px; overflow: hidden;">
            <thead style="background: #2b5797; color: white;">
                <tr>
                    <th>Date & Time</th>
                    <th>Patient Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Reason</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments ?? [] as $appointment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y h:i A') }}</td>
                    <td>{{ $appointment->patient->user->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($appointment->appointment_type) }}</td>
                    <td>
                        <span class="badge 
                            @if($appointment->status === 'scheduled') bg-primary
                            @elseif($appointment->status === 'completed') bg-success
                            @elseif($appointment->status === 'cancelled') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>
                    <td>{{ $appointment->reason ?? '-' }}</td>
                    <td>
                        <a href="{{ route('doctor.patient.view', $appointment->patient_id) }}" class="btn btn-sm" style="background: #2b5797; color: white;">View Patient</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4" style="color: #666;">
                        <p class="mb-2">No appointments scheduled.</p>
                        <small>Your schedule is currently empty.</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .table thead th {
        border: none;
        padding: 1rem;
    }

    .table tbody td {
        padding: 0.875rem 1rem;
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background: #f8f9fa;
    }
</style>
@endsection