@extends('layouts.dashboard_v2')

@section('title', 'Update Patient Status')

@section('page-title', 'Update Patient Status')

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
<!-- Back -->
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('doctor.patient.view', $patient->id) }}" class="btn-v2 btn-v2-secondary">
        ← Back to Patient Details
    </a>
</div>

<!-- Patient -->
<div class="card-v2 mb-4">
    <div class="card-body">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 60px; height: 60px; background: var(--bg-cream); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 600;">
                {{ strtoupper(substr($patient->user->name ?? 'P', 0, 1)) }}
            </div>
            <div>
                <h5 style="margin: 0 0 0.25rem 0; font-weight: 600;">{{ $patient->user->name ?? 'Unknown' }}</h5>
                <p style="margin: 0; color: var(--text-muted); font-size: 0.875rem;">
                    Current Status:
                    <span class="badge-v2 
                        @if($patient->status === 'Admitted') badge-admitted
                        @elseif($patient->status === 'Surgery') badge-surgery
                        @else badge-discharged
                        @endif">
                        {{ $patient->status }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Form -->
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Update Status</h5>
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

        <form action="{{ route('doctor.patient.update-status.post', $patient->id) }}" method="POST">
            @csrf

            <div class="form-group-v2">
                <label class="form-label-v2" for="status">New Status *</label>
                <select class="form-control-v2" id="status" name="status" required>
                    <option value="">Select Status</option>
                    <option value="Admitted" {{ $patient->status === 'Admitted' ? 'selected' : '' }}>Admitted</option>
                    <option value="Surgery" {{ $patient->status === 'Surgery' ? 'selected' : '' }}>Surgery</option>
                    <option value="Discharged" {{ $patient->status === 'Discharged' ? 'selected' : '' }}>Discharged</option>
                </select>
                @error('status')
                <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group-v2">
                <label class="form-label-v2" for="notes">Notes (Optional)</label>
                <textarea class="form-control-v2" id="notes" name="notes" rows="4" placeholder="Add any notes about this status change...">{{ old('notes') }}</textarea>
                @error('notes')
                <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group-v2">
                <label class="form-label-v2" for="last_visited_date">Last Visited Date</label>
                <input type="date" class="form-control-v2" id="last_visited_date" name="last_visited_date" value="{{ $patient->last_visited_date ?? old('last_visited_date') }}">
                @error('last_visited_date')
                <span class="text-danger" style="font-size: 0.875rem; color: #dc3545;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn-v2 btn-v2-primary">
                    Update Status
                </button>
                <a href="{{ route('doctor.patient.view', $patient->id) }}" class="btn-v2 btn-v2-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection