@extends('layouts.dashboard_v2')

@section('title', 'Create Medical Record')

@section('page-title', 'Create Medical Record')

@section('sidebar-menu')
<a href="{{ route('doctor.dashboard') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7"></rect>
        <rect x="14" y="3" width="7" height="7"></rect>
        <rect x="14" y="14" width="7" height="7"></rect>
        <rect x="3" y="14" width="7" height="7"></rect>
    </svg>
    Dashboard
</a>
<a href="{{ route('doctor.patients') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
        <circle cx="9" cy="7" r="4"></circle>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
    </svg>
    My Patients
</a>
<a href="{{ route('doctor.schedule') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
    </svg>
    My Schedule
</a>
<a href="{{ route('doctor.profile') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    Profile
</a>
@endsection

@section('content')
<!-- Back Button -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('doctor.patient.view', $patient->id) }}" class="btn-v2 btn-v2-secondary">
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

<!-- Create Record Form -->
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">New Medical Record</h5>
    </div>
    <div class="card-body">
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

        <form action="{{ route('doctor.patient.create-record.post', $patient->id) }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="diagnosis">Diagnosis *</label>
                        <input type="text" class="form-control-v2" id="diagnosis" name="diagnosis" value="{{ old('diagnosis') }}" placeholder="Enter diagnosis" required>
                        @error('diagnosis')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="treatment">Treatment *</label>
                        <input type="text" class="form-control-v2" id="treatment" name="treatment" value="{{ old('treatment') }}" placeholder="Enter treatment plan" required>
                        @error('treatment')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group-v2">
                <label class="form-label-v2" for="medications">Medications</label>
                <textarea class="form-control-v2" id="medications" name="medications" rows="3" placeholder="List prescribed medications...">{{ old('medications') }}</textarea>
                @error('medications')
                <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="blood_pressure">Blood Pressure</label>
                        <input type="text" class="form-control-v2" id="blood_pressure" name="blood_pressure" value="{{ old('blood_pressure') }}" placeholder="e.g., 120/80 mmHg">
                        @error('blood_pressure')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="temperature">Temperature</label>
                        <input type="text" class="form-control-v2" id="temperature" name="temperature" value="{{ old('temperature') }}" placeholder="e.g., 98.6°F">
                        @error('temperature')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="weight">Weight (kg)</label>
                        <input type="number" step="0.1" class="form-control-v2" id="weight" name="weight" value="{{ old('weight') }}" placeholder="e.g., 70.5">
                        @error('weight')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-v2">
                        <label class="form-label-v2" for="height">Height (cm)</label>
                        <input type="number" step="0.1" class="form-control-v2" id="height" name="height" value="{{ old('height') }}" placeholder="e.g., 175">
                        @error('height')
                        <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group-v2">
                <label class="form-label-v2" for="notes">Additional Notes</label>
                <textarea class="form-control-v2" id="notes" name="notes" rows="4" placeholder="Any additional observations or notes...">{{ old('notes') }}</textarea>
                @error('notes')
                <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group-v2">
                <label class="form-label-v2" for="follow_up_date">Follow-up Date</label>
                <input type="date" class="form-control-v2" id="follow_up_date" name="follow_up_date" value="{{ old('follow_up_date') }}">
                @error('follow_up_date')
                <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn-v2 btn-v2-primary">
                    Create Medical Record
                </button>
                <a href="{{ route('doctor.patient.view', $patient->id) }}" class="btn-v2 btn-v2-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
