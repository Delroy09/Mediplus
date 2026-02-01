@extends('layouts.dashboard_v2')

@section('title', 'Add New Doctor')

@section('page-title', 'Add New Doctor')

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
    <a href="{{ route('admin.doctors') }}" class="btn-v2 btn-v2-secondary">
        ← Back to Doctors
    </a>
</div>

<!-- Create Form -->
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Doctor Registration Form</h5>
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

        <form action="{{ route('admin.doctor.store') }}" method="POST">
            @csrf

            <h6 style="margin: 0 0 1rem 0; color: var(--text-muted); font-weight: 500;">Account Information</h6>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="name">Full Name *</label>
                        <input type="text" class="form-control-v2" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                        @error('name')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="email">Email Address *</label>
                        <input type="email" class="form-control-v2" id="email" name="email" value="{{ old('email') }}" placeholder="doctor@example.com" required>
                        @error('email')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="password">Password *</label>
                        <input type="password" class="form-control-v2" id="password" name="password" placeholder="Minimum 8 characters" required>
                        @error('password')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="password_confirmation">Confirm Password *</label>
                        <input type="password" class="form-control-v2" id="password_confirmation" name="password_confirmation" placeholder="Re-enter password" required>
                    </div>
                </div>
            </div>

            <hr style="margin: 1.5rem 0; border-color: var(--border-color);">
            <h6 style="margin: 0 0 1rem 0; color: var(--text-muted); font-weight: 500;">Professional Information</h6>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="consultation_hours">Consultation Hours</label>
                        <input type="text" class="form-control-v2" id="consultation_hours" name="consultation_hours" value="{{ old('consultation_hours') }}" placeholder="e.g., 9AM - 5PM">
                        @error('consultation_hours')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="dob">Date of Birth</label>
                        <input type="date" class="form-control-v2" id="dob" name="dob" value="{{ old('dob') }}">
                        @error('dob')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="specialization">Specialization *</label>
                        <input type="text" class="form-control-v2" id="specialization" name="specialization" value="{{ old('specialization') }}" placeholder="e.g., Cardiology" required>
                        @error('specialization')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="department">Department</label>
                        <input type="text" class="form-control-v2" id="department" name="department" value="{{ old('department') }}" placeholder="e.g., Internal Medicine">
                        @error('department')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="qualification">Qualification</label>
                        <input type="text" class="form-control-v2" id="qualification" name="qualification" value="{{ old('qualification') }}" placeholder="e.g., MD, MBBS">
                        @error('qualification')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="experience">Experience (years)</label>
                        <input type="number" class="form-control-v2" id="experience" name="experience" value="{{ old('experience') }}" placeholder="e.g., 10">
                        @error('experience')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn-v2 btn-v2-primary">
                    Create Doctor Account
                </button>
                <a href="{{ route('admin.doctors') }}" class="btn-v2 btn-v2-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection