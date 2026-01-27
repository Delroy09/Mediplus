@extends('layouts.dashboard_v2')

@section('title', 'Manage Patients')

@section('page-title', 'Manage Patients')

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
<!-- Status Filter -->
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('admin.patients') }}" class="btn-v2 {{ !request('status') ? 'btn-v2-primary' : 'btn-v2-secondary' }} btn-v2-sm">All</a>
        <a href="{{ route('admin.patients', ['status' => 'Admitted']) }}" class="btn-v2 {{ request('status') === 'Admitted' ? 'btn-v2-primary' : 'btn-v2-secondary' }} btn-v2-sm">Admitted</a>
        <a href="{{ route('admin.patients', ['status' => 'Surgery']) }}" class="btn-v2 {{ request('status') === 'Surgery' ? 'btn-v2-primary' : 'btn-v2-secondary' }} btn-v2-sm">Surgery</a>
        <a href="{{ route('admin.patients', ['status' => 'Discharged']) }}" class="btn-v2 {{ request('status') === 'Discharged' ? 'btn-v2-primary' : 'btn-v2-secondary' }} btn-v2-sm">Discharged</a>
    </div>
    <p style="margin: 0; color: var(--text-muted);">{{ $patients->count() ?? 0 }} patients found</p>
</div>

<!-- Patients Table -->
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">All Patients</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($patients) && count($patients) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Blood Group</th>
                        <th>Status</th>
                        <th>Assigned Doctor</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 40px; height: 40px; background: var(--bg-cream); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 500;">
                                    {{ strtoupper(substr($patient->user->name ?? 'P', 0, 1)) }}
                                </div>
                                <span style="font-weight: 500;">{{ $patient->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ $patient->user->email ?? 'N/A' }}</td>
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
                        <td>
                            @if($patient->doctors && $patient->doctors->count() > 0)
                            {{ $patient->doctors->first()->user->name ?? 'Unassigned' }}
                            @if($patient->doctors->count() > 1)
                            <span class="badge-v2 badge-admitted">+{{ $patient->doctors->count() - 1 }}</span>
                            @endif
                            @else
                            <span style="color: var(--text-muted);">Unassigned</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.patient.view', $patient->id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View</a>
                                <a href="{{ route('admin.patient.assign', $patient->id) }}" class="btn-v2 btn-v2-secondary btn-v2-sm">Assign</a>
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
            <p>No patients found.</p>
        </div>
        @endif
    </div>
</div>
@endsection
