@extends('layouts.dashboard_v2')

@section('title', 'Manage Account')

@section('page-title', 'Manage Account')

@section('sidebar-menu')
<a href="{{ route('patient.dashboard') }}">
    <i data-lucide="layout-grid"></i>
    Dashboard
</a>
<a href="{{ route('patient.profile') }}">
    <i data-lucide="user"></i>
    Edit Profile
</a>
<a href="{{ route('patient.schedule') }}">
    <i data-lucide="calendar"></i>
    My Schedule
</a>
<a href="{{ route('patient.manage') }}" class="active">
    <i data-lucide="settings"></i>
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
        <h5 style="margin: 0; font-weight: 600; color: #991B1B; display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="alert-triangle" style="width: 20px; height: 20px;"></i>
            Danger Zone
        </h5>
    </div>
    <div class="card-body">
        @if(isset($pendingDeletionRequest) && $pendingDeletionRequest)
        <!-- Pending deletion request banner -->
        <div class="alert alert-warning" role="alert" style="background: #fef3c7; border: 1px solid #fbbf24; color: #92400e; margin-bottom: 0;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="clock" style="width: 20px; height: 20px;"></i>
                <strong>Deletion Request Pending</strong>
            </div>
            <p style="margin-top: 0.5rem; margin-bottom: 0;">Your account deletion request has been submitted on <strong>{{ \Carbon\Carbon::parse($pendingDeletionRequest->created_at)->format('M d, Y') }}</strong>. An administrator will review it shortly.</p>
        </div>
        @elseif(($patient->status ?? 'Discharged') === 'Discharged')
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
                <i data-lucide="trash-2" style="width: 18px; height: 18px;"></i>
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