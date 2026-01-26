@extends('NewUI.layouts.dashboard_v2')

@section('title', 'Manage Assignments')

@section('page-title', 'Doctor-Patient Assignments')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard.v2') }}">
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
<a href="{{ route('admin.assignments.v2') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="9 11 12 14 22 4"></polyline>
        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
    </svg>
    Assignments
</a>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success mb-4" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 1rem; border-radius: 8px;">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger mb-4" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 1rem; border-radius: 8px;">
    {{ session('error') }}
</div>
@endif

<!-- New Assignment Form -->
<div class="card-v2 mb-4">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Create New Assignment</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.assignment.store') }}" method="POST">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <div class="form-group-v2" style="margin-bottom: 12px;">
                        <label class="form-label-v2" for="doctor_id">Select Doctor</label>
                        <select class="form-control-v2" id="doctor_id" name="doctor_id" required>
                            <option value="">-- Select Doctor --</option>
                            @foreach($doctors ?? [] as $doctor)
                            <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name ?? 'Unknown' }} - {{ $doctor->specialization ?? 'General' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-v2" style="margin-bottom: 24px;">
                        <label class="form-label-v2" for="patient_id">Select Patient: </label>
                        <select class="form-control-v2" id="patient_id" name="patient_id" required>
                            <option value="">-- Select Patient --</option>
                            @foreach($patients ?? [] as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name ?? 'Unknown' }} - {{ $patient->blood_group ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn-v2 btn-v2-primary" style="padding: 14px; margin-bottom:18px;">
                        Create Assignment
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Current Assignments -->
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Current Assignments</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($assignments) && count($assignments) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Specialization</th>
                        <th>Patient</th>
                        <th>Patient Status</th>
                        <th>Assigned Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $assignment)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary-teal), #2a6b6b); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 500; color: white;">
                                    {{ strtoupper(substr($assignment->doctor->user->name ?? 'D', 0, 1)) }}
                                </div>
                                <span style="font-weight: 500;">Dr. {{ $assignment->doctor->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>{{ $assignment->doctor->specialization ?? 'N/A' }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; background: var(--bg-cream); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 500;">
                                    {{ strtoupper(substr($assignment->patient->user->name ?? 'P', 0, 1)) }}
                                </div>
                                <span>{{ $assignment->patient->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge-v2 
                                @if($assignment->patient->status === 'Admitted') badge-admitted
                                @elseif($assignment->patient->status === 'Surgery') badge-surgery
                                @else badge-discharged
                                @endif">
                                {{ $assignment->patient->status ?? 'N/A' }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($assignment->created_at)->format('M d, Y') }}</td>
                        <td>
                            <form action="{{ route('admin.assignment.delete', $assignment->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-v2 btn-v2-danger btn-v2-sm" onclick="return confirm('Remove this assignment?')">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">🔗</div>
            <p>No assignments created yet.</p>
            <small style="color: var(--text-muted);">Use the form above to assign patients to doctors.</small>
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