<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi+ | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="global.css">
    <style>
        /* Flat Design - Inspired by Stripe, Linear */
        :root {
            --primary: #0066FF;
            --primary-dark: #0052CC;
            --text-primary: #1a202c;
            --text-secondary: #718096;
            --bg-gray: #F7FAFC;
            --border-color: #E2E8F0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Inter', sans-serif;
            color: var(--text-primary);
            line-height: 1.7;
            font-size: 16px;
        }

        /* Improved readability */
        p {
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            line-height: 1.3;
            margin-bottom: 1rem;
        }

        .navbar {
            background: #ffffff !important;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary) !important;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-secondary) !important;
            transition: color 0.2s;
            font-size: 1rem;
            padding: 0.5rem 1rem !important;
            min-height: 44px;
            display: flex;
            align-items: center;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: var(--text-primary) !important;
            outline: 2px solid transparent;
        }

        .nav-link:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        .hero-section {
            background: #ffffff;
            padding: 120px 0 80px;
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .card {
            border: 2px solid var(--border-color);
            border-radius: 12px;
        }

        .card-body {
            padding: 2rem;
        }

        .card-header {
            padding: 1.5rem 2rem;
        }

        .btn {
            border-radius: 8px;
            padding: 14px 28px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s;
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--primary-dark);
        }

        .btn-primary:focus-visible {
            outline: 3px solid rgba(0, 102, 255, 0.4);
            outline-offset: 2px;
        }

        .btn-outline-primary {
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .btn-outline-primary:hover {
            background: var(--bg-gray);
            border-color: var(--text-secondary);
            color: var(--text-primary);
        }

        footer {
            background: var(--text-primary);
            color: white;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            min-height: 48px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.15);
            outline: none;
        }

        .form-control::placeholder {
            color: #A0AEC0;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .form-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: 0.375rem;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .badge {
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .alert {
            border-radius: 8px;
            border: 2px solid;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #F0FDF4;
            border-color: #86EFAC;
            color: #166534;
        }

        .alert-danger {
            background: #FEF2F2;
            border-color: #FCA5A5;
            color: #991B1B;
        }

        /* Skip to main content for accessibility */
        .skip-to-main {
            position: absolute;
            top: -40px;
            left: 0;
            background: var(--primary);
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 0 0 8px 0;
        }

        .skip-to-main:focus {
            top: 0;
        }

        /* Focus styles for keyboard navigation */
        *:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        .accordion-button {
            padding: 1rem 1.5rem;
            font-size: 1rem;
            min-height: 56px;
            border: 1px solid var(--border-color);
            border-radius: 8px !important;
            background: white;
        }

        .accordion-button:not(.collapsed) {
            background: var(--bg-gray);
            color: var(--text-primary);
            font-weight: 600;
            border-color: var(--border-color);
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.15);
            border-color: var(--primary);
        }

        .accordion-item {
            border: none !important;
            margin-bottom: 0.75rem;
        }

        .accordion-body {
            padding: 1.5rem;
            font-size: 1rem;
            line-height: 1.8;
            color: var(--text-secondary);
            background: white;
            border: 1px solid var(--border-color);
            border-top: none;
            border-radius: 0 0 8px 8px;
        }

        .accordion-button.collapsed {
            border-radius: 8px !important;
        }
    </style>
</head>

<body>
    <a href="#main-content" class="skip-to-main">Skip to main content</a>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm" role="navigation" aria-label="Main navigation">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}" aria-label="Medi+ Home">Medi+</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

    <footer class="text-center mt-5">
        <div class="text-center p-4" style="background: #1a202c; color: rgba(255,255,255,0.9);">
            <p class="mb-0">© 2026 Medi+ Patient Management System</p>
            <p class="mb-0 small mt-1" style="opacity: 0.7;">Built by Delroy Pires</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>