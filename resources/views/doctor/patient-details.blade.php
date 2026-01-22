@extends('layouts.dashboard-layout')

@section('title', 'Patient Details')

@section('page-title', 'Patient Details')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}">Dashboard</a>
<a href="{{ route('doctor.patients') }}">My Patients</a>
<a href="{{ route('doctor.schedule') }}">My Schedule</a>
<a href="{{ route('doctor.profile') }}">Profile</a>
@endsection

@section('content')
<div class="content-box">
    <h5 style="margin-bottom: 25px; font-weight: 600;">Patient Information</h5>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="info-row">
                <strong>Full Name:</strong> &nbsp; {{ $patient->user->name ?? 'N/A' }}
            </div>
            <div class="info-row">
                <strong>DOB:</strong> &nbsp; {{ $patient->dob ?? 'N/A' }}
            </div>
            <div class="info-row">
                <strong>Age:</strong> &nbsp; {{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->age : 'N/A' }}
            </div>
            <div class="info-row">
                <strong>Gender:</strong> &nbsp; {{ ucfirst($patient->gender ?? 'N/A') }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-row">
                <strong>Blood Group:</strong> &nbsp; {{ $patient->blood_group ?? 'N/A' }}
            </div>
            <div class="info-row">
                <strong>Mobile:</strong> &nbsp; {{ $patient->mobile_number ?? 'N/A' }}
            </div>
            <div class="info-row">
                <strong>Email:</strong> &nbsp; {{ $patient->user->email ?? 'N/A' }}
            </div>
            <div class="info-row">
                <strong>Status:</strong> &nbsp;
                <span class="badge 
                    @if($patient->status === 'Admitted') bg-success
                    @elseif($patient->status === 'Surgery') bg-warning
                    @else bg-info
                    @endif">
                    {{ $patient->status }}
                </span>
            </div>
        </div>
    </div>

    <div class="info-row">
        <strong>Address:</strong> &nbsp; {{ $patient->address ?? 'N/A' }}
    </div>

    <div class="info-row">
        <strong>Emergency Contact:</strong> &nbsp; {{ $patient->emergency_contact_name ?? 'N/A' }} ({{ $patient->emergency_contact_number ?? 'N/A' }})
    </div>

    <hr style="margin: 25px 0;">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 style="font-weight: 600;">Medical Records</h5>
        <a href="{{ route('doctor.patient.create-record', $patient->id) }}" class="btn btn-sm" style="background: #2b5797; color: white;">Add New Record</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover bg-white" style="border-radius: 8px; overflow: hidden;">
            <thead style="background: #2b5797; color: white;">
                <tr>
                    <th>Visit Date</th>
                    <th>Symptoms</th>
                    <th>Diagnosis</th>
                    <th>Treatment</th>
                    <th>Doctor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicalRecords ?? [] as $record)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($record->visit_date)->format('d/m/Y') }}</td>
                    <td>{{ $record->symptoms }}</td>
                    <td>{{ $record->diagnosis }}</td>
                    <td>{{ $record->treatment }}</td>
                    <td>Dr. {{ $record->doctor->user->name ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4" style="color: #666;">
                        <p class="mb-2">No medical records found.</p>
                        <small>Add the first medical record for this patient.</small>
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