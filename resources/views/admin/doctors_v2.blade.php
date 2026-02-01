@extends('layouts.dashboard_v2')

@section('title', 'Manage Doctors')

@section('page-title', 'Manage Doctors')

@section('sidebar-menu')
<a href="{{ route('admin.dashboard') }}">
    <i data-lucide="layout-grid"></i>
    Dashboard
</a>
<a href="{{ route('admin.doctors') }}" class="active">
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
<!-- Action Bar -->
<div class="mb-4" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <p style="margin: 0; color: var(--text-muted);">{{ $doctors->count() ?? 0 }} doctors registered</p>
    </div>
    <a href="{{ route('admin.doctor.create') }}" class="btn-v2 btn-v2-primary">
        + Add New Doctor
    </a>
</div>

<!-- Doctors Table -->
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">All Doctors</h5>
    </div>
    <div class="card-body" style="padding: 0;">
        @if(isset($doctors) && count($doctors) > 0)
        <div class="scrollable-table">
            <table class="table-v2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Specialization</th>
                        <th>Department</th>
                        <th>Experience</th>
                        <th>Patients</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-teal), #2a6b6b); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 500; color: white;">
                                    {{ strtoupper(substr($doctor->user->name ?? 'D', 0, 1)) }}
                                </div>
                                <div>
                                    <span style="font-weight: 500; display: block;">{{ $doctor->user->name ?? 'N/A' }}</span>
                                    <small style="color: var(--text-muted);">{{ $doctor->qualification ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $doctor->user->email ?? 'N/A' }}</td>
                        <td>{{ $doctor->specialization ?? 'N/A' }}</td>
                        <td>{{ $doctor->department ?? 'N/A' }}</td>
                        <td>{{ $doctor->years_of_experience ?? 0 }} yrs</td>
                        <td>
                            <span class="badge-v2 badge-admitted">{{ $doctor->patients_count ?? 0 }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.doctor.view', $doctor->id) }}" class="btn-v2 btn-v2-primary btn-v2-sm">View</a>
                                <a href="{{ route('admin.doctor.edit', $doctor->id) }}" class="btn-v2 btn-v2-secondary btn-v2-sm">Edit</a>
                                <form action="{{ route('admin.doctor.delete', $doctor->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-v2 btn-v2-danger btn-v2-sm" onclick="return confirm('Are you sure you want to delete this doctor?')">Delete</button>
                                </form>
                            </div>
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
            <a href="{{ route('admin.doctor.create') }}" class="btn-v2 btn-v2-primary" style="margin-top: 1rem;">
                Add First Doctor
            </a>
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