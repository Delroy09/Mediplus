@extends('layouts.dashboard_v2')

@section('title', 'Edit Doctor')

@section('page-title', 'Edit Doctor')

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
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('admin.doctor.view', $doctor->id) }}" class="btn-v2 btn-v2-secondary">
        ← Back to Doctor Details
    </a>
</div>

<!-- Edit Form -->
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Edit Doctor Information</h5>
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

        <form action="{{ route('admin.doctor.update', $doctor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="name">Full Name *</label>
                        <input type="text" class="form-control-v2" id="name" name="name" value="{{ old('name', $doctor->user->name ?? '') }}" required>
                        @error('name')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="email">Email Address *</label>
                        <input type="email" class="form-control-v2" id="email" name="email" value="{{ old('email', $doctor->user->email ?? '') }}" required>
                        @error('email')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="consultation_hours">Consultation Hours</label>
                        <input type="text" class="form-control-v2" id="consultation_hours" name="consultation_hours" value="{{ old('consultation_hours', $doctor->consultation_hours ?? '') }}" placeholder="e.g., Mon-Fri: 9AM - 5PM">
                        @error('consultation_hours')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="dob">Date of Birth</label>
                        <input type="date" class="form-control-v2" id="dob" name="dob" value="{{ old('dob', $doctor->dob ?? '') }}">
                        @error('dob')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="specialization">Specialization *</label>
                        <input type="text" class="form-control-v2" id="specialization" name="specialization" value="{{ old('specialization', $doctor->specialization ?? '') }}" placeholder="e.g., Cardiology" required>
                        @error('specialization')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="department">Department</label>
                        <input type="text" class="form-control-v2" id="department" name="department" value="{{ old('department', $doctor->department ?? '') }}" placeholder="e.g., Internal Medicine">
                        @error('department')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="qualification">Qualification</label>
                        <input type="text" class="form-control-v2" id="qualification" name="qualification" value="{{ old('qualification', $doctor->qualification ?? '') }}" placeholder="e.g., MD, MBBS">
                        @error('qualification')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="experience">Experience (years)</label>
                        <input type="number" class="form-control-v2" id="experience" name="experience" value="{{ old('experience', $doctor->years_of_experience ?? 0) }}" placeholder="e.g., 10" min="0">
                        @error('experience')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                <button type="submit" class="btn-v2 btn-v2-primary">
                    Save Changes
                </button>
                <a href="{{ route('admin.doctor.view', $doctor->id) }}" class="btn-v2 btn-v2-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection