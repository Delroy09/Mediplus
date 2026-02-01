@extends('layouts.dashboard_v2')

@section('title', 'Edit Profile')

@section('page-title', 'Edit Profile')

@section('sidebar-menu')
<a href="{{ route('patient.dashboard') }}">
    <i data-lucide="layout-grid"></i>
    Dashboard
</a>
<a href="{{ route('patient.profile') }}" class="active">
    <i data-lucide="user"></i>
    Edit Profile
</a>
<a href="{{ route('patient.schedule') }}">
    <i data-lucide="calendar"></i>
    My Schedule
</a>
<a href="{{ route('patient.manage') }}">
    <i data-lucide="settings"></i>
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