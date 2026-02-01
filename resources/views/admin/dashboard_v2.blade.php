@extends('layouts.dashboard_v2')

@section('title', 'Admin Dashboard')

@section('page-title', 'Admin Dashboard')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard') }}" class="active">
    <i data-lucide="layout-grid"></i>
    Dashboard
</a>
<a href="{{ route('admin.doctors') }}">
    <i data-lucide="stethoscope"></i>
    Doctors
</a>
<a href="{{ route('admin.patients') }}">
    <i data-lucide="users"></i>
    Patients
</a>
<a href="{{ route('admin.assignments') }}">
    <i data-lucide="clipboard-list"></i>
    Assignments
</a>
@endsection

@section('content')
<!-- Welcome Card -->
<div class="card-v2 mb-4" style="background: linear-gradient(135deg, var(--primary-teal), #2a6b6b); color: white;">
    <div class="card-body">
        <h4 style="margin: 0 0 0.5rem 0; font-weight: 600; color: black;">Welcome, Administrator!</h4>
        <p style="margin: 0; opacity: 0.9; color: black;">Manage doctors, patients, and assignments from this dashboard.</p>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(61, 139, 139, 0.1);">
                <i data-lucide="user-check" style="color: #3b82f6;"></i>
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
                <i data-lucide="users" style="color: #3b82f6;"></i>
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
                <i data-lucide="clock" style="color: #f59e0b;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $pendingRequestsCount ?? 0 }}</div>
                <div class="stat-label">Pending Requests</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34, 197, 94, 0.1);">
                <i data-lucide="link" style="color: #22c55e;"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $totalAssignments ?? 0 }}</div>
                <div class="stat-label">Assignments</div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Account Requests (New Patient Registrations) -->
@if(isset($pendingRequests) && count($pendingRequests) > 0)
<div class="card-v2 mb-4">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Pending Account Requests</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Blood Group</th>
                        <th>Gender</th>
                        <th>Requested On</th>
                        <th>Assign Doctor</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingRequests as $request)
                    <tr>
                        <td style="font-weight: 500;">{{ $request->name }}</td>
                        <td>{{ $request->email }}</td>
                        <td>{{ $request->blood_group ?? 'N/A' }}</td>
                        <td>{{ ucfirst($request->gender ?? 'N/A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y') }}</td>
                        <td>
                            <form action="{{ route('admin.approve', $request->id) }}" method="POST" id="approveForm{{ $request->id }}">
                                @csrf
                                <select name="doctor_id" class="form-control-v2" style="min-width: 150px; padding: 0.5rem;" required>
                                    <option value="">Select Doctor</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->user->name ?? 'Unknown' }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="submit" form="approveForm{{ $request->id }}" class="btn-v2 btn-v2-primary btn-v2-sm" onclick="return confirm('Approve this request?')">Approve</button>
                                <form action="{{ route('admin.reject', $request->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-v2 btn-v2-danger btn-v2-sm" onclick="return confirm('Reject this request?')">Reject</button>
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

<!-- Pending Deletion Requests -->
@if(isset($pendingDeletionRequests) && count($pendingDeletionRequests) > 0)
<div class="card-v2 mb-4" style="border-left: 4px solid #dc2626;">
    <div class="card-header" style="background: #fef2f2; border-bottom: 1px solid #fecaca;">
        <h5 style="margin: 0; font-weight: 600; color: #991b1b; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="trash-2" style="width: 20px; height: 20px;"></i>
            Patient Account Deletion Requests
        </h5>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Reason</th>
                        <th>Requested On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingDeletionRequests as $request)
                    <tr>
                        <td>{{ $request->patient->user->name ?? 'N/A' }}</td>
                        <td>{{ $request->patient->user->email ?? 'N/A' }}</td>
                        <td><span style="color: #6b7280; font-size: 0.875rem;">{{ Str::limit($request->reason, 40) }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.approve-deletion', $request->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-v2 btn-v2-danger btn-v2-sm" onclick="return confirm('⚠️ This will permanently delete the patient account and all related data. Continue?')">Delete Account</button>
                                </form>
                                <form action="{{ route('admin.reject-deletion', $request->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-v2 btn-v2-secondary btn-v2-sm">Reject Request</button>
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
<div class="card-v2 mb-4">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h5 style="margin: 0; font-weight: 600;">Recent Doctors</h5>
        <a href="{{ route('admin.doctors') }}" class="btn-v2 btn-v2-secondary btn-v2-sm">View All</a>
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
                                <span style="font-weight: 500;">{{ $doctor->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ $doctor->user->email ?? 'N/A' }}</td>
                        <td>{{ $doctor->specialization ?? 'N/A' }}</td>
                        <td>{{ $doctor->department ?? 'N/A' }}</td>
                        <td>{{ $doctor->patients_count ?? 0 }}</td>
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
            <p>No doctors registered yet.</p>
        </div>
        @endif
    </div>
</div>

<!-- Recent Patients -->
<div class="card-v2">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h5 style="margin: 0; font-weight: 600;">Recent Patients</h5>
        <a href="{{ route('admin.patients') }}" class="btn-v2 btn-v2-secondary btn-v2-sm">View All</a>
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