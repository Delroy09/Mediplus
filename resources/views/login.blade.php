@extends('layouts.master')

@section('title', 'Login')

@section('content')
<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="mb-3" style="font-size: 3rem;">🏥</div>
                        <h2 class="fw-bold" style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">Medi+</h2>
                        <p class="text-muted">Sign in to your account</p>
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus>
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
                            <button type="submit" class="btn btn-primary btn-lg shadow">Log In</button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted mb-2">Don't have an account?</p>
                            <a href="{{ url('/contact') }}" class="text-decoration-none fw-bold">Apply for one here →</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection