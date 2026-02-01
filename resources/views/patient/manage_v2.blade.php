@extends('layouts.dashboard_v2')

@section('title', 'Manage Account')

@section('page-title', 'Manage Account')

@section('sidebar-menu')
<a href="{{ route('patient.dashboard') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7"></rect>
        <rect x="14" y="3" width="7" height="7"></rect>
        <rect x="14" y="14" width="7" height="7"></rect>
        <rect x="3" y="14" width="7" height="7"></rect>
    </svg>
    Dashboard
</a>
<a href="{{ route('patient.profile') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    Edit Profile
</a>
<a href="{{ route('patient.schedule') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
    </svg>
    My Schedule
</a>
<a href="{{ route('patient.manage') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="3"></circle>
        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
    </svg>
    Manage Account
</a>
@endsection

@section('content')
<div class="card-v2">
    <div class="card-header">
        <h5 style="margin: 0; font-weight: 600;">Account Information</h5>
    </div>
    <div class="card-body">
        <div class="info-row-v2">
            <span class="label">Full Name</span>
            <span class="value">{{ $user->name ?? 'Nash Dsouza' }}</span>
        </div>
        <div class="info-row-v2">
            <span class="label">Email Address</span>
            <span class="value">{{ $user->email ?? 'nds@gmail.com' }}</span>
        </div>
        <div class="info-row-v2">
            <span class="label">Patient Status</span>
            <span class="value">
                <span class="badge-v2 
                    @if(($patient->status ?? 'Discharged') === 'Admitted') badge-admitted
                    @elseif(($patient->status ?? 'Discharged') === 'Surgery') badge-surgery
                    @else badge-discharged
                    @endif">
                    {{ $patient->status ?? 'Discharged' }}
                </span>
            </span>
        </div>
    </div>
</div>

<div class="card-v2 mt-4" style="border-color: #FCA5A5;">
    <div class="card-header" style="background: #FEF2F2; border-bottom-color: #FECACA;">
        <h5 style="margin: 0; font-weight: 600; color: #991B1B;">⚠️ Danger Zone</h5>
    </div>
    <div class="card-body">
        @if(($patient->status ?? 'Discharged') === 'Discharged')
        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
            Once you request account deletion, all your data will be permanently removed. This action cannot be undone.
        </p>
        <form action="{{ route('patient.request-deletion') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label-v2">Reason for Deletion</label>
                <textarea name="reason" class="form-control form-control-v2" rows="3" required placeholder="Please provide a reason for account deletion..."></textarea>
            </div>
            <button type="submit" class="btn-v2 btn-v2-danger" onclick="return confirm('Are you sure you want to request account deletion? This action cannot be undone.')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
                Request Account Deletion
            </button>
        </form>
        @else
        <div class="alert alert-info" role="alert" style="margin-bottom: 0;">
            You can only request account deletion after being discharged from the hospital.
        </div>
        @endif
    </div>
</div>
@endsection