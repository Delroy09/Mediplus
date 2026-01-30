@extends('layouts.dashboard_v2')

@section('title', 'Patient Details')

@section('page-title', 'Patient Details')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7"></rect>
        <rect x="14" y="3" width="7" height="7"></rect>
        <rect x="14" y="14" width="7" height="7"></rect>
        <rect x="3" y="14" width="7" height="7"></rect>
    </svg>
    Dashboard
</a>
<a href="{{ route('admin.doctors') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    Doctors
</a>
<a href="{{ route('admin.patients') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    Patients
</a>
<a href="{{ route('admin.assignments') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="9 11 12 14 22 4"></polyline>
        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
    </svg>
    Assignments
</a>
@endsection

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('admin.patients') }}" class="btn-v2 btn-v2-secondary">
        ← Back to Patients
    </a>
</div>

<!-- Patient Info Card -->
<div class="card-v2 mb-4">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h5 style="margin: 0; font-weight: 600;">Patient Information</h5>
        <a href="{{ route('admin.patient.assign', $patient->id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">Assign Doctor</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3" style="text-align: center; padding-right: 2rem; border-right: 1px solid var(--border-color);">
                <div style="width: 80px; height: 80px; background: var(--bg-cream); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 2rem; font-weight: 600;">
                    {{ strtoupper(substr($patient->user->name ?? 'P', 0, 1)) }}
                </div>
                <h5 style="margin: 0 0 0.25rem 0; font-weight: 600;">{{ $patient->user->name ?? 'Unknown' }}</h5>
                <span class="badge-v2 
                    @if($patient->status === 'Admitted') badge-admitted
                    @elseif($patient->status === 'Surgery') badge-surgery
                    @else badge-discharged
                    @endif">
                    {{ $patient->status }}
                </span>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-group">
                            <label>Email</label>
                            <p>{{ $patient->user->email ?? 'N/A' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Date of Birth</label>
                            <p>{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Age</label>
                            <p>{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->age . ' years' : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-group">
                            <label>Gender</label>
                            <p>{{ ucfirst($patient->gender ?? 'N/A') }}</p>
                        </div>
                        <div class="info-group">
                            <label>Blood Group</label>
                            <p>{{ $patient->blood_group ?? 'N/A' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Mobile Number</label>
                            <p>{{ $patient->mobile_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assigned Doctors -->
<div class="card-v2 mb-4">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Assigned Doctors</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($patient->doctors) && count($patient->doctors) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Doctor Name</th>
                        <th>Specialization</th>
                        <th>Department</th>
                        <th>Experience</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patient->doctors as $doctor)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary-teal), #2a6b6b); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 500; color: white;">
                                    {{ strtoupper(substr($doctor->user->name ?? 'D', 0, 1)) }}
                                </div>
                                <span style="font-weight: 500;">{{ $doctor->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ $doctor->specialization ?? 'N/A' }}</td>
                        <td>{{ $doctor->department ?? 'N/A' }}</td>
                        <td>{{ $doctor->years_of_experience ?? 0 }} yrs</td>
                        <td>
                            <a href="{{ route('admin.doctor.view', $doctor->id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">👨‍⚕️</div>
            <p>No doctors assigned to this patient.</p>
            <a href="{{ route('admin.patient.assign', $patient->id) }}" class="btn-v2 btn-v2-primary" style="margin-top: 1rem;">
                Assign Doctor
            </a>
        </div>
        @endif
    </div>
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
                        <th>Doctor</th>
                        <th>Diagnosis</th>
                        <th>Treatment</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicalRecords as $record)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($record->created_at)->format('M d, Y') }}</td>
                        <td>{{ $record->doctor->user->name ?? 'N/A' }}</td>
                        <td>{{ $record->diagnosis ?? 'N/A' }}</td>
                        <td>{{ $record->treatment ?? 'N/A' }}</td>
                        <td>{{ Str::limit($record->notes ?? '-', 50) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <p>No medical records found.</p>
        </div>
        @endif
    </div>
</div>

<style>
    .info-group {
        margin-bottom: 1rem;
    }

    .info-group label {
        display: block;
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .info-group p {
        margin: 0;
        font-weight: 500;
    }
</style>
@endsection