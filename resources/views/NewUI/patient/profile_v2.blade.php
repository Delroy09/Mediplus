@extends('NewUI.layouts.dashboard_v2')

@section('title', 'Edit Profile')

@section('page-title', 'Edit Profile')

@section('sidebar-menu')
<a href="{{ route('patient.dashboard.v2') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="7" height="7"></rect>
        <rect x="14" y="3" width="7" height="7"></rect>
        <rect x="14" y="14" width="7" height="7"></rect>
        <rect x="3" y="14" width="7" height="7"></rect>
    </svg>
    Dashboard
</a>
<a href="{{ route('patient.profile.v2') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    Edit Profile
</a>
<a href="{{ route('patient.schedule.v2') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
    </svg>
    My Schedule
</a>
<a href="{{ route('patient.manage.v2') }}">
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
        <h5 style="margin: 0; font-weight: 600;">Profile Information</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('patient.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label-v2">Full Name</label>
                        <input type="text" class="form-control form-control-v2" value="{{ $user->name ?? 'Nash Dsouza' }}" readonly style="background: var(--bg-cream);">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label-v2">Email Address</label>
                        <input type="email" class="form-control form-control-v2" value="{{ $user->email ?? 'nds@gmail.com' }}" readonly style="background: var(--bg-cream);">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label-v2">Date of Birth</label>
                        <input type="text" class="form-control form-control-v2" value="{{ $patient->dob ?? '31/12/2003' }}" readonly style="background: var(--bg-cream);">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label-v2">Gender</label>
                        <input type="text" class="form-control form-control-v2" value="{{ ucfirst($patient->gender ?? 'Male') }}" readonly style="background: var(--bg-cream);">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label-v2">Age</label>
                        <input type="text" class="form-control form-control-v2" value="{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->age : 23 }}" readonly style="background: var(--bg-cream);">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label-v2">Status</label>
                        <input type="text" class="form-control form-control-v2" value="{{ $patient->status ?? 'Discharged' }}" readonly style="background: var(--bg-cream);">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label-v2">Last Visit</label>
                <input type="text" class="form-control form-control-v2" value="{{ $patient->last_visited_date ?? '31/12/2003' }}" readonly style="background: var(--bg-cream);">
            </div>

            <div style="background: var(--primary-light); padding: 1rem; border-radius: 8px; margin-top: 1rem;">
                <p style="margin: 0; font-size: 0.9rem; color: var(--primary-dark);">
                    <strong>Note:</strong> To update your profile information, please contact the hospital administration.
                </p>
            </div>
        </form>
    </div>
</div>
@endsection