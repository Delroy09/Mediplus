@extends('layouts.dashboard-layout')

@section('title', 'My Schedule')

@section('page-title', 'My Schedule')

@section('sidebar-menu')
<a href="{{ route('patient.dashboard') }}">Dashboard</a>
<a href="{{ route('patient.profile') }}">Edit Profile</a>
<a href="{{ route('patient.schedule') }}" class="active">My Schedule</a>
<a href="{{ route('patient.manage') }}">Manage Account</a>
@endsection

@section('content')
<div class="content-box">
    <h5 style="margin-bottom: 20px; font-weight: 600;">Appointment History</h5>

    <div class="table-responsive">
        <table class="table table-hover bg-white" style="border-radius: 8px; overflow: hidden;">
            <thead style="background: #2b5797; color: white;">
                <tr>
                    <th>Date & Time</th>
                    <th>Doctor</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments ?? [] as $appointment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y h:i A') }}</td>
                    <td>Dr. {{ $appointment->doctor->user->name ?? 'N/A' }}</td>
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
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4" style="color: #666;">
                        <p class="mb-2">No appointments scheduled yet.</p>
                        <small>Contact your assigned doctor to schedule an appointment.</small>
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