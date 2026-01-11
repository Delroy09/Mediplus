<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi+ | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* A nice Medical Blue theme */
        :root { --primary-color: #0d6efd; --secondary-color: #6c757d; }
        .navbar-brand { font-weight: bold; color: var(--primary-color) !important; }
        .hero-section { background-color: #f8f9fa; padding: 60px 0; }
        .feature-icon { font-size: 2rem; color: var(--primary-color); margin-bottom: 1rem; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Medi+</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact / Request Account</a></li>
                    
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item"><a class="btn btn-primary ms-2" href="{{ url('/dashboard') }}">Dashboard</a></li>
                        @else
                            <li class="nav-item"><a class="btn btn-outline-primary ms-2" href="{{ route('login') }}">Login</a></li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2026 Medi+ Patient Management System | CA-2 Project
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>