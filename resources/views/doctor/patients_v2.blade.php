@extends('layouts.dashboard_v2')

@section('title', 'My Patients')

@section('page-title', 'My Patients')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}">
    <i data-lucide="layout-grid"></i>
    Dashboard
</a>
<a href="{{ route('doctor.patients') }}" class="active">
    <i data-lucide="users"></i>
    My Patients
</a>
<a href="{{ route('doctor.schedule') }}">
    <i data-lucide="calendar"></i>
    My Schedule
</a>
<a href="{{ route('doctor.profile') }}">
    <i data-lucide="user"></i>
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