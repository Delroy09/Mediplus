@extends('layouts.dashboard_v2')

@section('title', 'Manage Assignments')

@section('page-title', 'Manage Assignments')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard') }}">
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
<a href="{{ route('admin.assignments') }}" class="active">
    <i data-lucide="clipboard-list"></i>
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

<div class="card-v2 mb-4">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Create New Assignment</h5>
    </div>
    <div class="card-body">
        @if(count($patients ?? []) === 0)
        <div class="alert alert-warning mb-3" role="alert">
            All patients are currently assigned. Unassign a patient to make them available for new assignments.
        </div>
        @endif
        <form action="{{ route('admin.assignment.store') }}" method="POST">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <div class="form-group-v2" style="margin-bottom: 24px;">
                        <label class="form-label-v2" for="doctor_id">Select Doctor</label>
                        <select class="form-control-v2" id="doctor_id" name="doctor_id" required>
                            <option value="">-- Select Doctor --</option>
                            @foreach($doctors ?? [] as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->user->name ?? 'Unknown' }} - {{ $doctor->specialization ?? 'General' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group-v2" style="margin-bottom: 24px;">
                        <label class="form-label-v2" for="patient_id">Select Patient: </label>
                        <select class="form-control-v2" id="patient_id" name="patient_id" required @if(count($patients ?? [])===0) disabled @endif>
                            <option value="">-- Select Patient --</option>
                            @foreach($patients ?? [] as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name ?? 'Unknown' }} - {{ $patient->blood_group ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn-v2 btn-v2-primary" style="padding: 14px; margin-bottom:18px;" @if(count($patients ?? [])===0) disabled @endif>
                        Create Assignment
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card-v2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 style="margin: 0; font-weight: 600;">Current Assignments</h5>
        <input type="text" id="assignmentSearchInput" class="form-control-v2" style="width: 240px; margin-left: 1rem;" placeholder="Search assignments..." oninput="filterAssignmentsTable()">
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($assignments) && count($assignments) > 0)
        <div class="scrollable-table">
            <table class="table-v2" id="assignmentsTable">
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
                                <div class="avatar-initial" style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--primary-teal), #2a6b6b); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 500; color: white;">
                                    {{ strtoupper(substr($assignment->doctor->user->name ?? 'D', 0, 1)) }}
                                </div>
                                <span class="search-text" style="font-weight: 500;">{{ $assignment->doctor->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="search-text">{{ $assignment->doctor->specialization ?? 'N/A' }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div class="avatar-initial" style="width: 36px; height: 36px; background: var(--bg-cream); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 500;">
                                    {{ strtoupper(substr($assignment->patient->user->name ?? 'P', 0, 1)) }}
                                </div>
                                <span class="search-text">{{ $assignment->patient->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge-v2 search-text 
                                @if($assignment->patient->status === 'Admitted') badge-admitted
                                @elseif($assignment->patient->status === 'Surgery') badge-surgery
                                @else badge-discharged
                                @endif">
                                {{ $assignment->patient->status ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="search-text">{{ \Carbon\Carbon::parse($assignment->created_at)->format('M d, Y') }}</td>
                        <td>
                            <form action="{{ route('admin.assignment.delete', $assignment->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-v2 btn-v2-danger btn-v2-sm" onclick="return confirm('Remove this assignment?')">
                                    <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
            No active assignments found.
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/assignments-search.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/assignments-search.css') }}">
@endpush