@extends('layouts.dashboard-layout')

@section('title', 'My Patients')

@section('page-title', 'My Patients')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}">Dashboard</a>
<a href="{{ route('doctor.patients') }}" class="active">My Patients</a>
<a href="{{ route('doctor.schedule') }}">My Schedule</a>
<a href="{{ route('doctor.profile') }}">Profile</a>
@endsection

@section('content')
<div class="content-box">
    <h5 style="margin-bottom: 20px; font-weight: 600;">All Assigned Patients</h5>

    <div class="table-responsive">
        <table class="table table-hover bg-white" style="border-radius: 8px; overflow: hidden;">
            <thead style="background: #2b5797; color: white;">
                <tr>
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Blood Group</th>
                    <th>Status</th>
                    <th>Last Visit</th>
                    <th>Mobile</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients ?? [] as $patient)
                <tr>
                    <td>{{ $patient->user->name ?? 'N/A' }}</td>
                    <td>{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->age : 'N/A' }}</td>
                    <td>{{ ucfirst($patient->gender ?? 'N/A') }}</td>
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
                    <td>{{ $patient->mobile_number ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('doctor.patient.view', $patient->id) }}" class="btn btn-sm" style="background: #2b5797; color: white;">View</a>
                        <a href="{{ route('doctor.patient.update-status', $patient->id) }}" class="btn btn-sm btn-warning">Update</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4" style="color: #666;">
                        <p class="mb-2">No patients assigned yet.</p>
                        <small>Please contact the IT administrator for patient assignments.</small>
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
        font-size: 14px;
    }

    .table-hover tbody tr:hover {
        background: #f8f9fa;
    }
</style>
@endsection