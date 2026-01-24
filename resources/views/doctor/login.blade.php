@extends('layouts.master')

@section('title', 'Doctor Login')

@section('content')
<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <h2 class="fw-bold mb-2" style="color: var(--primary);">Medi+</h2>
                        <p style="color: var(--text-secondary);">Doctor Portal - Sign in to your work account</p>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('doctor.login.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Work Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="doctor@mediplus.com" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Log In</button>
                        </div>

                        <div class="text-center mt-4">
                            <p style="color: var(--text-secondary); margin-bottom: 0.5rem; font-size: 0.9rem;">For Testing: Use seeded doctor email with password: <code>password</code></p>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('home') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">← Back to Home</a> |
                            <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Patient Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection