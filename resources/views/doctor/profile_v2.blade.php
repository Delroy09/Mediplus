@extends('layouts.dashboard_v2')

@section('title', 'My Profile')

@section('page-title', 'My Profile')

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
<a href="{{ route('doctor.patients') }}">
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
<a href="{{ route('doctor.profile') }}" class="active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
    </svg>
    Profile
</a>
@endsection

@section('content')
<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-lg-4">
        <div class="card-v2">
            <div class="card-body" style="text-align: center; padding: 2rem;">
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--primary-teal), #2a6b6b); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2.5rem; color: white; font-weight: 600;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'D', 0, 1)) }}
                </div>
                <h4 style="margin: 0 0 0.5rem 0; font-weight: 600;">Dr. {{ Auth::user()->name ?? 'Unknown' }}</h4>
                <p style="margin: 0; color: var(--text-muted);">{{ $doctor->specialization ?? 'Specialist' }}</p>
                <hr style="margin: 1.5rem 0; border-color: var(--border-color);">
                <div style="text-align: left;">
                    <div class="profile-info-item">
                        <span class="profile-info-icon">📧</span>
                        <span>{{ Auth::user()->email ?? 'N/A' }}</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-icon">📱</span>
                        <span>{{ $doctor->phone ?? 'Not provided' }}</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-icon">🏥</span>
                        <span>{{ $doctor->department ?? 'General' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Card -->
    <div class="col-lg-8">
        <div class="card-v2">
            <div class="card-header">
                <h5 style="margin: 0; font-weight: 600;">Professional Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-group">
                            <label>Full Name</label>
                            <p>Dr. {{ Auth::user()->name ?? 'N/A' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Email Address</label>
                            <p>{{ Auth::user()->email ?? 'N/A' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Phone Number</label>
                            <p>{{ $doctor->phone ?? 'Not provided' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Date of Birth</label>
                            <p>{{ isset($doctor->dob) ? \Carbon\Carbon::parse($doctor->dob)->format('M d, Y') : 'Not provided' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-group">
                            <label>Specialization</label>
                            <p>{{ $doctor->specialization ?? 'Not specified' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Department</label>
                            <p>{{ $doctor->department ?? 'General' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Qualification</label>
                            <p>{{ $doctor->qualification ?? 'Not provided' }}</p>
                        </div>
                        <div class="info-group">
                            <label>Experience</label>
                            <p>{{ $doctor->experience ?? 'Not provided' }} {{ $doctor->experience ? 'years' : '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="card-v2" style="margin-top: 1.5rem;">
            <div class="card-header">
                <h5 style="margin: 0; font-weight: 600;">Statistics Overview</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="mini-stat">
                            <div class="mini-stat-value">{{ $totalPatients ?? 0 }}</div>
                            <div class="mini-stat-label">Total Patients</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat">
                            <div class="mini-stat-value">{{ $activePatients ?? 0 }}</div>
                            <div class="mini-stat-label">Active</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat">
                            <div class="mini-stat-value">{{ $totalRecords ?? 0 }}</div>
                            <div class="mini-stat-label">Medical Records</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat">
                            <div class="mini-stat-value">{{ $upcomingAppointments ?? 0 }}</div>
                            <div class="mini-stat-label">Appointments</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }

    .profile-info-icon {
        font-size: 1.1rem;
    }

    .info-group {
        margin-bottom: 1.25rem;
    }

    .info-group label {
        display: block;
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .info-group p {
        margin: 0;
        font-weight: 500;
    }

    .mini-stat {
        background: var(--bg-cream);
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
    }

    .mini-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-teal);
    }

    .mini-stat-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }
</style>
@endsection
