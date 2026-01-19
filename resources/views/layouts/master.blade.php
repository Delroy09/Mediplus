<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi+ | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
        /* Modern Medical Theme */
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0a58ca;
            --secondary-color: #6c757d;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-blue: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        .hero-section {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(13,110,253,0.1)"/></svg>');
            opacity: 0.4;
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .card {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }

        .card:hover .feature-icon {
            transform: scale(1.2) rotate(5deg);
        }

        .btn {
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--gradient-blue);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
        }

        .btn-outline-primary:hover {
            background: var(--gradient-blue);
            border: none;
        }

        footer {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        .accordion-button:not(.collapsed) {
            background: var(--gradient-blue);
            color: white;
        }

        .accordion-button:focus {
            box-shadow: none;
        }
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
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Apply Now</a></li>

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

    <footer class="text-center text-lg-start mt-5">
        <div class="text-center p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <p class="mb-0">© 2026 Medi+ Patient Management System | <strong>CA-2 Project</strong></p>
            <p class="mb-0 small mt-2 opacity-75">Built with ❤️ by Delroy Pires</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>