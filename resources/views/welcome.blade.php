@extends('layouts.master')

@section('title', 'Welcome')

@section('content')

<section class="hero-section text-center position-relative">
    <div class="container position-relative">
        <div class="mb-4">
            <span class="badge bg-primary bg-gradient px-4 py-2 rounded-pill mb-3">Your Health, Our Priority</span>
        </div>
        <h1 class="display-3 fw-bold mb-3" style="color: #2d3748;">Welcome to Medi+</h1>
        <p class="lead fs-4 mb-2" style="color: #4a5568;">Advanced Patient Management System</p>
        <p class="fs-5 mb-5" style="color: #718096;">Bridging the gap between Doctors, Patients & Administration</p>

        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ url('/contact') }}" class="btn btn-primary btn-lg shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-text me-2" viewBox="0 0 16 16">
                    <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                    <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                </svg>
                Apply Now
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-right me-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                </svg>
                Staff Login
            </a>
        </div>
    </div>
</section>

<section id="features" class="container my-5 py-5">
    <div class="row text-center mb-5">
        <div class="col-12">
            <span class="badge bg-primary bg-gradient px-3 py-2 rounded-pill mb-3">Features</span>
            <h2 class="display-5 fw-bold mb-3">Comprehensive Care System</h2>
            <p class="lead text-muted">Designed for efficiency, security and seamless patient care</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow border-0 bg-gradient">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">🏥</div>
                    <h5 class="card-title fw-bold mb-3">Patient Portal</h5>
                    <p class="card-text text-muted"><b>View</b> your admission status, assigned doctor, and <b>update</b> your contact details <b>securely</b> from anywhere.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow border-0 bg-gradient">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">👨‍⚕️</div>
                    <h5 class="card-title fw-bold mb-3">Doctor Dashboard</h5>
                    <p class="card-text text-muted">Manage assigned patients, track discharge status, and view complete medical history in <b>one unified platform.</b></p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow border-0 bg-gradient">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">🛡️</div>
                    <h5 class="card-title fw-bold mb-3">Secure Admin</h5>
                    <p class="card-text text-muted">IT Department controlled access ensures only <b>verified</b> users can access sensitive medical data with full audit trails.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection