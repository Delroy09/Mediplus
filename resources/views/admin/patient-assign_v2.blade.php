@extends('layouts.dashboard_v2')

@section('title', 'Assign Doctor to Patient')

@section('page-title', 'Assign Doctor')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard') }}">
    <i data-lucide="layout-grid"></i>
    Dashboard
</a>
<a href="{{ route('admin.doctors') }}">
    <i data-lucide="stethoscope"></i>
    Doctors
</a>
<a href="{{ route('admin.patients') }}" class="active">
    <i data-lucide="users"></i>
    Patients
</a>
<a href="{{ route('admin.assignments') }}">
    <i data-lucide="clipboard-list"></i>
    Assignments
</a>
@endsection

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('admin.patient.view', $patient->id) }}" class="btn-v2 btn-v2-secondary">
        ← Back to Patient Details
    </a>
</div>

<!-- Patient Summary -->
<div class="card-v2 mb-4">
    <div class="card-body">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 60px; height: 60px; background: var(--bg-cream); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 600;">
                {{ strtoupper(substr($patient->user->name ?? 'P', 0, 1)) }}
            </div>
            <div>
                <h5 style="margin: 0 0 0.25rem 0; font-weight: 600;">{{ $patient->user->name ?? 'Unknown' }}</h5>
                <p style="margin: 0; color: var(--text-muted); font-size: 0.875rem;">
                    {{ $patient->blood_group ?? 'Unknown Blood Group' }} • {{ ucfirst($patient->gender ?? 'Unknown') }} •
                    {{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->age . ' years old' : 'Age unknown' }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Assignment Form -->
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Select Doctor to Assign</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('admin.patient.assign.post', $patient->id) }}" method="POST">
            @csrf

            <div class="form-group-v2">
                <label class="form-label-v2" for="doctor_id">Select Doctor *</label>
                <select class="form-control-v2" id="doctor_id" name="doctor_id" required>
                    <option value="">-- Choose a Doctor --</option>
                    @foreach($doctors ?? [] as $doctor)
                    <option value="{{ $doctor->id }}" {{ in_array($doctor->id, $assignedDoctorIds ?? []) ? 'disabled' : '' }}>
                        {{ $doctor->user->name ?? 'Unknown' }}
                        - {{ $doctor->specialization ?? 'General' }}
                        ({{ $doctor->department ?? 'N/A' }})
                        {{ in_array($doctor->id, $assignedDoctorIds ?? []) ? '- Already Assigned' : '' }}
                    </option>
                    @endforeach
                </select>
                @error('doctor_id')
                <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn-v2 btn-v2-primary">
                    Assign Doctor
                </button>
                <a href="{{ route('admin.patient.view', $patient->id) }}" class="btn-v2 btn-v2-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Available Doctors Preview -->
<div class="card-v2" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Available Doctors</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($doctors) && count($doctors) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Specialization</th>
                        <th>Department</th>
                        <th>Current Patients</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
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
                        <td>{{ $doctor->patients_count ?? 0 }}</td>
                        <td>
                            @if(in_array($doctor->id, $assignedDoctorIds ?? []))
                            <span class="badge-v2 badge-admitted">Assigned</span>
                            @else
                            <span class="badge-v2 badge-discharged">Available</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">👨‍⚕️</div>
            <p>No doctors available.</p>
        </div>
        @endif
    </div>
</div>
@endsection