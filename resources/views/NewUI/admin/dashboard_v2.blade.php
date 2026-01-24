@extends('NewUI.layouts.dashboard_v2')

@section('title', 'Admin Dashboard')

@section('page-title', 'Admin Dashboard')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard.v2') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7"></rect>
        <rect x="14" y="3" width="7" height="7"></rect>
        <rect x="14" y="14" width="7" height="7"></rect>
        <rect x="3" y="14" width="7" height="7"></rect>
    </svg>
    Dashboard
</a>
<a href="{{ route('admin.doctors.v2') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    Doctors
</a>
<a href="{{ route('admin.patients.v2') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    Patients
</a>
<a href="{{ route('admin.assignments.v2') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="9 11 12 14 22 4"></polyline>
        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
    </svg>
    Assignments
</a>
@endsection

@section('content')
<!-- Welcome Card -->
<div class="card-v2" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, var(--primary-teal), #2a6b6b); color: white;">
    <div class="card-body">
        <h4 style="margin: 0 0 0.5rem 0; font-weight: 600;">Welcome, Administrator!</h4>
        <p style="margin: 0; opacity: 0.9;">Manage doctors, patients, and assignments from this dashboard.</p>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4" style="margin-bottom: 1.5rem;">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(61, 139, 139, 0.1);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary-teal)" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalDoctors ?? 0 }}</div>
                <div class="stat-label">Total Doctors</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalPatients ?? 0 }}</div>
                <div class="stat-label">Total Patients</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $pendingRequests ?? 0 }}</div>
                <div class="stat-label">Pending Requests</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.1);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                    <polyline points="9 11 12 14 22 4"></polyline>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalAssignments ?? 0 }}</div>
                <div class="stat-label">Assignments</div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests -->
@if(isset($pendingDeletionRequests) && count($pendingDeletionRequests) > 0)
<div class="card-v2" style="margin-bottom: 1.5rem; border-left: 4px solid #f59e0b;">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">⚠️ Pending Deletion Requests</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Requested On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingDeletionRequests as $request)
                    <tr>
                        <td>{{ $request->patient->user->name ?? 'N/A' }}</td>
                        <td>{{ $request->patient->user->email ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.approve-deletion', $request->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-v2 btn-v2-danger btn-v2-sm" onclick="return confirm('Are you sure?')">Approve</button>
                                </form>
                                <form action="{{ route('admin.reject-deletion', $request->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-v2 btn-v2-secondary btn-v2-sm">Reject</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- Recent Doctors -->
<div class="card-v2" style="margin-bottom: 1.5rem;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h5 style="margin: 0; font-weight: 600;">Recent Doctors</h5>
        <a href="{{ route('admin.doctors.v2') }}" class="btn-v2 btn-v2-secondary btn-v2-sm">View All</a>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($recentDoctors) && count($recentDoctors) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Specialization</th>
                        <th>Department</th>
                        <th>Patients</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentDoctors as $doctor)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; background: var(--bg-cream); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 500;">
                                    {{ strtoupper(substr($doctor->user->name ?? 'D', 0, 1)) }}
                                </div>
                                <span style="font-weight: 500;">Dr. {{ $doctor->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ $doctor->user->email ?? 'N/A' }}</td>
                        <td>{{ $doctor->specialization ?? 'N/A' }}</td>
                        <td>{{ $doctor->department ?? 'N/A' }}</td>
                        <td>{{ $doctor->patients_count ?? 0 }}</td>
                        <td>
                            <a href="{{ route('admin.doctor.view.v2', $doctor->id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">👨‍⚕️</div>
            <p>No doctors registered yet.</p>
        </div>
        @endif
    </div>
</div>

<!-- Recent Patients -->
<div class="card-v2">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h5 style="margin: 0; font-weight: 600;">Recent Patients</h5>
        <a href="{{ route('admin.patients.v2') }}" class="btn-v2 btn-v2-secondary btn-v2-sm">View All</a>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($recentPatients) && count($recentPatients) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Blood Group</th>
                        <th>Status</th>
                        <th>Assigned Doctor</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPatients as $patient)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; background: var(--bg-cream); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 500;">
                                    {{ strtoupper(substr($patient->user->name ?? 'P', 0, 1)) }}
                                </div>
                                <span style="font-weight: 500;">{{ $patient->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ $patient->user->email ?? 'N/A' }}</td>
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
                        <td>{{ $patient->doctors->first()->user->name ?? 'Unassigned' }}</td>
                        <td>
                            <a href="{{ route('admin.patient.view.v2', $patient->id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">👥</div>
            <p>No patients registered yet.</p>
        </div>
        @endif
    </div>
</div>

<style>
    .btn-v2-danger {
        background: #ef4444;
        color: white;
    }

    .btn-v2-danger:hover {
        background: #dc2626;
    }
</style>
@endsection