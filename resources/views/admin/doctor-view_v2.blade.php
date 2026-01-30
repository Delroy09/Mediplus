@extends('layouts.dashboard_v2')

@section('title', 'Doctor Details')

@section('page-title', 'Doctor Details')

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
<a href="{{ route('admin.doctors') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    Doctors
</a>
<a href="{{ route('admin.patients') }}">
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
    <a href="{{ route('admin.doctors') }}" class="btn-v2 btn-v2-secondary">
        ← Back to Doctors
    </a>
</div>

<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-lg-4">
        <div class="card-v2">
            <div class="card-body" style="text-align: center; padding: 2rem;">
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary-teal), #2a6b6b); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2.5rem; color: white; font-weight: 600;">
                    {{ strtoupper(substr($doctor->user->name ?? 'D', 0, 1)) }}
                </div>
                <h4 style="margin: 0 0 0.5rem 0; font-weight: 600;">{{ $doctor->user->name ?? 'Unknown' }}</h4>
                <p style="margin: 0; color: var(--text-muted);">{{ $doctor->specialization ?? 'Specialist' }}</p>
                <hr style="margin: 1.5rem 0; border-color: var(--border-color);">
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('admin.doctor.edit', $doctor->id) }}" class="btn-v2 btn-v2-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Card -->
    <div class="col-lg-8">
        <div class="card-v2">
            <div class="card-header">
                <h5 style="margin: 0; font-weight: 600;">Professional Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-group">
                            <label>Full Name</label>
                            <p>{{ $doctor->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Email Address</label>
                            <p>{{ $doctor->user->email ?? 'N/A' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Consultation Hours</label>
                            <p>{{ $doctor->consultation_hours ?? 'Not specified' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-group">
                            <label>Specialization</label>
                            <p>{{ $doctor->specialization ?? 'Not specified' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Department</label>
                            <p>{{ $doctor->department ?? 'General' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Qualification</label>
                            <p>{{ $doctor->qualification ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assigned Patients -->
<div class="card-v2" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Assigned Patients ({{ $doctor->patients->count() ?? 0 }})</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($doctor->patients) && count($doctor->patients) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Blood Group</th>
                        <th>Status</th>
                        <th>Last Visit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctor->patients as $patient)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 32px; height: 32px; background: var(--bg-cream); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 500; font-size: 0.875rem;">
                                    {{ strtoupper(substr($patient->user->name ?? 'P', 0, 1)) }}
                                </div>
                                <span>{{ $patient->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->age : 'N/A' }}</td>
                        <td>{{ $patient->blood_group ?? 'N/A' }}</td>
                        <td>
                            <span class="badge-v2 
                                @if($patient->status === 'Admitted') badge-admitted
                                @elseif($patient->status === 'Surgery') badge-surgery
                                @else badge-discharged
                                @endif">
                                {{ $patient->status }}
                            </span>
                        </td>
                        <td>{{ $patient->last_visited_date ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.patient.view', $patient->id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">👥</div>
            <p>No patients assigned to this doctor.</p>
            <a href="{{ route('admin.assignments') }}" class="btn-v2 btn-v2-primary" style="margin-top: 1rem;">
                Assign Patients
            </a>
        </div>
        @endif
    </div>
</div>

<style>
    .info-group {
        margin-bottom: 1.25rem;
    }

    .info-group label {
        display: block;
        font-size: 0.8rem;
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