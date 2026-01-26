@extends('NewUI.layouts.dashboard_v2')

@section('title', 'Patient Details')

@section('page-title', 'Patient Details')

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
<a href="{{ route('doctor.patients.v2') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    My Patients
</a>
<a href="{{ route('doctor.schedule.v2') }}">
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
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('doctor.patients.v2') }}" class="btn-v2 btn-v2-secondary">
        ← Back to Patients
    </a>
</div>

<!-- Patient Info Card -->
<div class="card-v2 mb-4">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Patient Information</h5>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label">Full Name</div>
                    <div class="info-value">{{ $patient->user->name ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $patient->user->email ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Date of Birth</div>
                    <div class="info-value">{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->format('M d, Y') : 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Age</div>
                    <div class="info-value">{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->age . ' years' : 'N/A' }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-row">
                    <div class="info-label">Gender</div>
                    <div class="info-value">{{ ucfirst($patient->gender ?? 'N/A') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Blood Group</div>
                    <div class="info-value">{{ $patient->blood_group ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Mobile Number</div>
                    <div class="info-value">{{ $patient->mobile_number ?? 'N/A' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Current Status</div>
                    <div class="info-value">
                        <span class="badge-v2 
                            @if($patient->status === 'Admitted') badge-admitted
                            @elseif($patient->status === 'Surgery') badge-surgery
                            @else badge-discharged
                            @endif">
                            {{ $patient->status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="mb-4" style="display: flex; gap: 1rem;">
    <a href="{{ route('doctor.patient.update-status.v2', $patient->id) }}" class="btn-v2 btn-v2-primary">
        Update Status
    </a>
    <a href="{{ route('doctor.patient.create-record.v2', $patient->id) }}" class="btn-v2 btn-v2-secondary">
        Add Medical Record
    </a>
</div>

<!-- Medical Records -->
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Medical Records</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($medicalRecords) && count($medicalRecords) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Diagnosis</th>
                        <th>Treatment</th>
                        <th>Medications</th>
                        <th>Notes</th>
                        <th>Created By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicalRecords as $record)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($record->created_at)->format('M d, Y') }}</td>
                        <td>{{ $record->diagnosis ?? 'N/A' }}</td>
                        <td>{{ $record->treatment ?? 'N/A' }}</td>
                        <td>{{ $record->medications ?? 'N/A' }}</td>
                        <td>{{ Str::limit($record->notes ?? 'N/A', 50) }}</td>
                        <td>{{ $record->doctor->user->name ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <p>No medical records found.</p>
            <a href="{{ route('doctor.patient.create-record.v2', $patient->id) }}" class="btn-v2 btn-v2-primary" style="margin-top: 1rem;">
                Create First Record
            </a>
        </div>
        @endif
    </div>
</div>

<style>
    .info-row {
        display: flex;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        width: 140px;
        color: var(--text-muted);
        font-size: 0.875rem;
    }

    .info-value {
        flex: 1;
        font-weight: 500;
    }
</style>
@endsection