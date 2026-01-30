@extends('layouts.master_v2')

@section('title', 'Login')

@section('content')

<section style="background: var(--bg-cream); min-height: calc(100vh - 200px); display: flex; align-items: center; padding: 3rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card-v2">
                    <div class="card-body" style="padding: 2.5rem;">

                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div style="width: 60px; height: 60px; background: var(--primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 1.75rem; font-weight: 700;">+</div>
                            <h2 class="font-serif" style="font-size: 1.75rem; margin-bottom: 0.5rem;">Welcome back</h2>
                            <p style="color: var(--text-secondary); font-size: 0.95rem;">Sign in to your patient account</p>
                        </div>

                        <!-- Errors -->
                        @if ($errors->any())
                        <div class="alert" style="background: #FEF2F2; border: none; border-radius: 12px; color: #991B1B; padding: 1rem; margin-bottom: 1.5rem;">
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                <li><span style="margin-right: 0.5rem;">⚠</span> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Form -->
                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label-v2">Email Address</label>
                                <input type="email"
                                    class="form-control form-control-v2"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="you@example.com"
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
                                    Sign In
                                </button>
                            </div>

                            <!-- Divider -->
                            <div class="text-center mb-4" style="position: relative;">
                                <hr style="border-color: var(--border-color);">
                                <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 0 1rem; color: var(--text-muted); font-size: 0.85rem;">or</span>
                            </div>

                            <!-- Links -->
                            <div class="text-center">
                                <p style="color: var(--text-secondary); margin-bottom: 0.5rem; font-size: 0.95rem;">Don't have an account?</p>
                                <a href="{{ route('contact') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Apply for an account →</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Employee Link -->
                <div class="text-center mt-4">
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 0.5rem;">Are you a medical staff member?</p>
                    <a href="{{ route('doctor.login') }}" style="color: var(--primary); text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Employee Portal
                    </a>
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