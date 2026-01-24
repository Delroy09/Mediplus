@extends('NewUI.layouts.master_v2')

@section('title', 'Doctor Login')

@section('content')

<section style="background: var(--bg-cream); min-height: calc(100vh - 200px); display: flex; align-items: center; padding: 3rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card-v2">
                    <div class="card-body" style="padding: 2.5rem;">

                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 1.5rem;">👨‍⚕️</div>
                            <h2 class="font-serif" style="font-size: 1.75rem; margin-bottom: 0.5rem;">Doctor Portal</h2>
                            <p style="color: var(--text-secondary); font-size: 0.95rem;">Sign in to your work account</p>
                        </div>

                        <!-- Success Message -->
                        @if(session('success'))
                        <div class="alert" style="background: #ECFDF5; border: none; border-radius: 12px; color: #065F46; padding: 1rem; margin-bottom: 1.5rem;">
                            <span style="margin-right: 0.5rem;">✓</span> {{ session('success') }}
                        </div>
                        @endif

                        <!-- Error Messages -->
                        @if(session('error'))
                        <div class="alert" style="background: #FEF2F2; border: none; border-radius: 12px; color: #991B1B; padding: 1rem; margin-bottom: 1.5rem;">
                            <span style="margin-right: 0.5rem;">⚠</span> {{ session('error') }}
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert" style="background: #FEF2F2; border: none; border-radius: 12px; color: #991B1B; padding: 1rem; margin-bottom: 1.5rem;">
                            <ul class="mb-0 list-unstyled">
                                @foreach($errors->all() as $error)
                                <li><span style="margin-right: 0.5rem;">⚠</span> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('doctor.login.v2.submit') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label-v2">Work Email Address</label>
                                <input type="email"
                                    class="form-control form-control-v2"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="doctor@mediplus.com"
                                    required
                                    autofocus>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label-v2">Password</label>
                                <input type="password"
                                    class="form-control form-control-v2"
                                    id="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    required>
                            </div>

                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember" style="border-radius: 4px;">
                                    <label class="form-check-label" for="remember" style="font-size: 0.9rem; color: var(--text-secondary);">Remember me</label>
                                </div>
                                <a href="#" style="font-size: 0.9rem; color: var(--primary); text-decoration: none;">Forgot password?</a>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn-cta" style="width: 100%; justify-content: center; padding: 1rem;">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 20px; height: 20px;">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                        <polyline points="10 17 15 12 10 7"></polyline>
                                        <line x1="15" y1="12" x2="3" y2="12"></line>
                                    </svg>
                                    Sign In to Portal
                                </button>
                            </div>

                            <!-- Testing Info -->
                            <div style="background: var(--primary-light); border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;">
                                <p style="color: var(--primary-dark); margin: 0; font-size: 0.85rem; text-align: center;">
                                    <strong>Testing:</strong> Use seeded doctor email with password: <code style="background: white; padding: 0.125rem 0.375rem; border-radius: 4px;">password</code>
                                </p>
                            </div>

                            <!-- Links -->
                            <div class="text-center">
                                <div class="d-flex justify-content-center gap-3" style="font-size: 0.9rem;">
                                    <a href="{{ route('home.v2') }}" style="color: var(--text-secondary); text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                                            <path d="M19 12H5M12 19l-7-7 7-7" />
                                        </svg>
                                        Back to Home
                                    </a>
                                    <span style="color: var(--border-color);">|</span>
                                    <a href="{{ route('login.v2') }}" style="color: var(--primary); text-decoration: none;">Patient Login</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Badge -->
                <div class="text-center mt-4">
                    <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: white; padding: 0.75rem 1.25rem; border-radius: 50px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); font-size: 0.85rem; color: var(--text-secondary);">
                        <span style="color: var(--primary);">🔒</span>
                        Secure staff-only portal
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('styles')
<style>
    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(61, 139, 139, 0.1);
        border-color: var(--primary);
    }
</style>
@endsection