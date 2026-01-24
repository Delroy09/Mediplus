@extends('NewUI.layouts.dashboard_v2')

@section('title', 'Edit Doctor')

@section('page-title', 'Edit Doctor')

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
<a href="{{ route('admin.doctors.v2') }}" class="active">
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
<!-- Back Button -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.doctor.view.v2', $doctor->id) }}" class="btn-v2 btn-v2-secondary">
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

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="name">Full Name *</label>
                        <input type="text" class="form-control-v2" id="name" name="name" value="{{ old('name', $doctor->user->name ?? '') }}" required>
                        @error('name')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="email">Email Address *</label>
                        <input type="email" class="form-control-v2" id="email" name="email" value="{{ old('email', $doctor->user->email ?? '') }}" required>
                        @error('email')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="phone">Phone Number</label>
                        <input type="text" class="form-control-v2" id="phone" name="phone" value="{{ old('phone', $doctor->phone ?? '') }}" placeholder="e.g., +1234567890">
                        @error('phone')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="dob">Date of Birth</label>
                        <input type="date" class="form-control-v2" id="dob" name="dob" value="{{ old('dob', $doctor->dob ?? '') }}">
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
                        <input type="text" class="form-control-v2" id="specialization" name="specialization" value="{{ old('specialization', $doctor->specialization ?? '') }}" placeholder="e.g., Cardiology" required>
                        @error('specialization')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="department">Department</label>
                        <input type="text" class="form-control-v2" id="department" name="department" value="{{ old('department', $doctor->department ?? '') }}" placeholder="e.g., Internal Medicine">
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
                        <input type="text" class="form-control-v2" id="qualification" name="qualification" value="{{ old('qualification', $doctor->qualification ?? '') }}" placeholder="e.g., MD, MBBS">
                        @error('qualification')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="experience">Experience (years)</label>
                        <input type="number" class="form-control-v2" id="experience" name="experience" value="{{ old('experience', $doctor->experience ?? '') }}" placeholder="e.g., 10">
                        @error('experience')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn-v2 btn-v2-primary">
                    Save Changes
                </button>
                <a href="{{ route('admin.doctor.view.v2', $doctor->id) }}" class="btn-v2 btn-v2-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection