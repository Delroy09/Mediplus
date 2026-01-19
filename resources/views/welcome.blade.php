@extends('layouts.master')

@section('title', 'Welcome')

@section('content')

<section class="hero-section text-center" id="main-content">
    <div class="container" style="max-width: 800px;">
        <div class="mb-4">
            <span class="badge bg-primary">Your Health, Our Priority</span>
        </div>
        <h1 class="fw-bold mb-4" style="font-size: clamp(2rem, 5vw, 3rem); color: var(--text-primary); line-height: 1.2;">Welcome to Medi+</h1>
        <p class="mb-2" style="font-size: 1.25rem; color: var(--text-primary);">Advanced Patient Management System</p>
        <p class="mb-5" style="font-size: 1.1rem; color: var(--text-secondary); max-width: 600px; margin-left: auto; margin-right: auto;">Bridging the gap between Doctors, Patients & Administration</p>

        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ url('/contact') }}" class="btn btn-primary btn-lg" aria-label="Apply for a new account">Apply Now</a>
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg" aria-label="Staff login page">Staff Login</a>
        </div>
    </div>
</section>

<section id="features" class="py-5" style="background: var(--bg-gray);">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-3" style="font-size: clamp(1.75rem, 4vw, 2.25rem); color: var(--text-primary);">Everything you need</h2>
                <p style="color: var(--text-secondary); font-size: 1.1rem;">A comprehensive patient management platform</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 bg-white">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">🏥</div>
                        <h5 class="fw-bold mb-3">Patient Portal</h5>
                        <p style="color: var(--text-secondary); margin: 0;">View admission status, assigned doctor, and update contact details securely from anywhere.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 bg-white">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">👨‍⚕️</div>
                        <h5 class="fw-bold mb-3">Doctor Dashboard</h5>
                        <p style="color: var(--text-secondary); margin: 0;">Manage assigned patients, track discharge status, and view complete medical history in one place.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 bg-white">
                    <div class="card-body p-4">
                        <div class="feature-icon mb-3">🛡️</div>
                        <h5 class="fw-bold mb-3">Secure Admin</h5>
                        <p style="color: var(--text-secondary); margin: 0;">IT-controlled access ensures only verified users can access sensitive medical data.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection