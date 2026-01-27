@extends('layouts.master_v2')

@section('title', 'Welcome')

@section('content')

<!-- Hero Section -->
<section class="hero-v2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <span class="tag-label">Patient Management System</span>
                <h1>
                    You care, We manage.<br>
                    <span class="highlight">Digital Healthcare.</span>
                </h1>
                <p class="hero-description">
                    Professional patient management system - with real administrators - designed to bridge the gap between doctors and patients — on <em>your</em> terms.
                </p>
                <a href="{{ route('contact') }}" class="btn-cta">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    Request Your Account
                </a>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-container text-center">
                    <!-- Hero Image -->
                    <img src="https://plus.unsplash.com/premium_photo-1661580574627-9211124e5c3f?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Doctor consulting with patient"
                        style="width: 100%; max-width: 480px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">

                    <!-- Floating Badges -->
                    <div class="floating-badge badge-1">
                        <span>✓</span> Convenient
                    </div>
                    <div class="floating-badge badge-2">
                        <span>♥</span> Caring
                    </div>
                    <div class="floating-badge badge-3">
                        <span>🔒</span> Confidential
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="how-it-works" id="how-it-works">
    <div class="container">
        <h2>Simple, Convenient, Effective</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Fill out a Quick Form</h3>
                    <p class="step-description">
                        Provide your basic information so we can create your patient account. No lengthy paperwork. Just essentials.
                    </p>
                    <span class="step-arrow d-none d-md-block">⟶</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-item">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Get Approved Within Hours</h3>
                    <p class="step-description">
                        Our IT team reviews and approves your application. You'll be matched with a doctor based on your needs.
                    </p>
                    <span class="step-arrow d-none d-md-block">⟶</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-item">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Access Your Dashboard</h3>
                    <p class="step-description">
                        Log in to your personalized portal — view your status, doctor info, and manage your healthcare journey digitally.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-v2" id="features">
    <div class="container">
        <div class="text-center mb-5">
            <span class="tag-label">Why Choose Us</span>
            <h2 class="font-serif mt-2" style="font-size: clamp(2rem, 4vw, 2.5rem);">Everything you need</h2>
            <p style="color: var(--text-secondary); max-width: 500px; margin: 0 auto;">A comprehensive healthcare management platform built for modern medical facilities</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-v2">🏥</div>
                    <h3>Patient Portal</h3>
                    <p>View admission status, assigned doctor, and update contact details securely from anywhere, anytime.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-v2">👨‍⚕️</div>
                    <h3>Doctor Dashboard</h3>
                    <p>Manage assigned patients, track treatment progress, and maintain comprehensive medical records in one place.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-v2">🛡️</div>
                    <h3>Secure Administration</h3>
                    <p>IT-controlled access ensures only verified users can access sensitive medical data with full audit trails.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-v2">📱</div>
                    <h3>Mobile Ready</h3>
                    <p>Access your health information on any device. Our responsive design works seamlessly on phone, tablet, or desktop.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-v2">⚡</div>
                    <h3>Real-time Updates</h3>
                    <p>Get instant notifications about appointment changes, doctor assignments, and important health updates.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon-v2">🔐</div>
                    <h3>Data Privacy</h3>
                    <p>Your medical information is encrypted and stored securely, compliant with all healthcare data regulations.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: var(--primary); padding: 4rem 0;">
    <div class="container text-center">
        <h2 class="font-serif text-white mb-3" style="font-size: clamp(1.75rem, 4vw, 2.25rem);">Ready to get started?</h2>
        <p class="text-white mb-4" style="opacity: 0.9; max-width: 500px; margin-left: auto; margin-right: auto;">
            Join thousands of patients who trust MediPlus for their healthcare management needs.
        </p>
        <a href="{{ route('contact') }}" class="btn-cta" style="background: white; color: var(--primary);">
            Apply for Your Account
        </a>
    </div>
</section>

@endsection
