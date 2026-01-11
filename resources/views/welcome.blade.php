@extends('layouts.master')

@section('title', 'Welcome')

@section('content')

<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Welcome to Medi+</h1>
        <p class="lead text-muted">Advanced Patient Management System(APMS)</p>
        <p class="mb-4">Bridging gap between Doctors, Patients, & Administration.</p>
        
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ url('/contact') }}" class="btn btn-primary btn-lg">Apply Now</a>
            <!-- <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">Staff Login</a> -->
        </div>
    </div>
</section>

<section id="features" class="container my-5">
    <div class="row text-center">
        <div class="col-12 mb-4">
            <h2>System Features</h2>
            <p class="text-muted">Designed for efficiency and care.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="feature-icon">🏥</div>
                    <h5 class="card-title">Patient Portal</h5>
                    <p class="card-text">View your admission status, assigned doctor, and update your contact details securely.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="feature-icon">👨‍⚕️</div>
                    <h5 class="card-title">Doctor Dashboard</h5>
                    <p class="card-text">Manage assigned patients, track discharge status, and view medical history in one place.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="feature-icon">🛡️</div>
                    <h5 class="card-title">Secure Admin</h5>
                    <p class="card-text">IT Department controlled access ensures only verified users can access sensitive medical data.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection