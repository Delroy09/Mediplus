@extends('layouts.dashboard-layout')

@section('title', 'Doctor Dashboard')

@section('page-title', 'Dashboard')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}" class="active">Dashboard</a>
<a href="{{ route('doctor.patients') }}">My Patients</a>
<a href="{{ route('doctor.schedule') }}">My Schedule</a>
<a href="{{ route('doctor.profile') }}">Profile</a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Welcome, Dr. {{ $user->name ?? 'Doctor Name' }}</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="p-3">
                            <h3 class="text-primary mb-0">{{ $stats['active_patients'] ?? 12 }}</h3>
                            <small class="text-muted">Active Patients</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <h3 class="text-success mb-0">{{ $stats['appointments_today'] ?? 5 }}</h3>
                            <small class="text-muted">Appointments Today</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <h3 class="text-warning mb-0">{{ $stats['pending_updates'] ?? 3 }}</h3>
                            <small class="text-muted">Pending Updates</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3">
                            <h3 class="text-info mb-0">{{ $stats['total_records'] ?? 47 }}</h3>
                            <small class="text-muted">Total Records</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="info-card">
            <h5 class="mb-4" style="color: #333; font-weight: 600;">Assigned Patients</h5>

            <div class="table-responsive">
                <table class="table table-hover bg-white" style="border-radius: 8px; overflow: hidden;">
                    <thead style="background: #4A7BA7; color: white;">
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
                        @forelse($patients ?? [] as $patient)
                        <tr>
                            <td>{{ $patient->user->name ?? 'Patient Name' }}</td>
                            <td>{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->age : 'N/A' }}</td>
                            <td>{{ $patient->blood_group ?? 'N/A' }}</td>
                            <td>
                                <span class="badge 
                                    @if($patient->status === 'Admitted') bg-success
                                    @elseif($patient->status === 'Surgery') bg-warning
                                    @else bg-info
                                    @endif">
                                    {{ $patient->status }}
                                </span>
                            </td>
                            <td>{{ $patient->last_visited_date ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('doctor.patient.view', $patient->id) }}" class="btn btn-sm btn-primary">View</a>
                                <a href="{{ route('doctor.patient.update-status', $patient->id) }}" class="btn btn-sm btn-warning">Update Status</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <p class="mb-2">No patients assigned yet.</p>
                                <small>Please contact the IT administrator for patient assignments.</small>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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