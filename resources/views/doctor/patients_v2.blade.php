@extends('layouts.dashboard_v2')

@section('title', 'My Patients')

@section('page-title', 'My Patients')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7"></rect>
        <rect x="14" y="3" width="7" height="7"></rect>
        <rect x="14" y="14" width="7" height="7"></rect>
        <rect x="3" y="14" width="7" height="7"></rect>
    </svg>
    Dashboard
</a>
<a href="{{ route('doctor.patients') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    My Patients
</a>
<a href="{{ route('doctor.schedule') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
    </svg>
    My Schedule
</a>
<a href="{{ route('doctor.profile') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    Profile
</a>
@endsection

@section('content')
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">All Assigned Patients</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($patients) && count($patients) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
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
                    @foreach($patients as $patient)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; background: var(--bg-cream); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 500;">
                                    {{ strtoupper(substr($patient->user->name ?? 'P', 0, 1)) }}
                                </div>
                                <span style="font-weight: 500;">{{ $patient->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->age : 'N/A' }}</td>
                        <td>{{ ucfirst($patient->gender ?? 'N/A') }}</td>
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
                        <td>{{ $patient->mobile_number ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('doctor.patient.view', $patient->id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View</a>
                                <a href="{{ route('doctor.patient.update-status', $patient->id) }}" class="btn-v2 btn-v2-secondary btn-v2-sm">Update</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">👥</div>
            <p>No patients assigned yet.</p>
            <small style="color: var(--text-muted);">Contact the IT administrator for patient assignments.</small>
        </div>
        @endif
    </div>
</div>
@endsection
