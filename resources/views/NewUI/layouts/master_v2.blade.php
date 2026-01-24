<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi+ | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #3D8B8B;
            --primary-dark: #2E7A7A;
            --primary-light: #E8F4F4;
            --text-primary: #1a202c;
            --text-secondary: #6B7280;
            --text-muted: #9CA3AF;
            --bg-cream: #FAFAF8;
            --bg-white: #FFFFFF;
            --border-color: #E5E7EB;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Ensure Bootstrap accordion works properly */
        .accordion-collapse {
            display: none;
        }

        .accordion-collapse.show {
            display: block;
        }

        .accordion-collapse.collapsing {
            display: block;
            height: 0;
            overflow: hidden;
            transition: height 0.35s ease;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
            font-size: 16px;
            background: var(--bg-cream);
        }

        /* Typography */
        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        h1,
        h2,
        h3 {
            line-height: 1.2;
        }

        /* Navbar */
        .navbar-v2 {
            background: var(--bg-white);
            padding: 1rem 0;
            border-bottom: none;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-v2 .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .navbar-v2 .brand-icon {
            width: 32px;
            height: 32px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .navbar-v2 .nav-link {
            font-weight: 500;
            color: var(--text-secondary);
            transition: color 0.2s;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            text-decoration: none;
        }

        .navbar-v2 .nav-link:hover {
            color: var(--text-primary);
        }

        .btn-cta {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-cta:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-cta svg {
            width: 18px;
            height: 18px;
        }

        /* Hero Section */
        .hero-v2 {
            background: var(--bg-white);
            padding: 4rem 0 6rem;
            min-height: 85vh;
            display: flex;
            align-items: center;
        }

        .hero-v2 .tag-label {
            display: inline-block;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .hero-v2 h1 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 400;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            line-height: 1.1;
        }

        .hero-v2 h1 .highlight {
            color: var(--primary);
            font-style: italic;
        }

        .hero-v2 .hero-description {
            font-size: 1.1rem;
            color: var(--text-secondary);
            max-width: 400px;
            margin: 1.5rem 0 2rem;
            line-height: 1.7;
        }

        .hero-v2 .hero-description em {
            font-style: italic;
        }

        /* Hero Image Section */
        .hero-image-container {
            position: relative;
        }

        .hero-image {
            width: 100%;
            max-width: 500px;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            object-fit: cover;
        }

        .floating-badge {
            position: absolute;
            background: var(--bg-white);
            border-radius: 50px;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-secondary);
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .floating-badge.badge-1 {
            top: 15%;
            right: 0;
        }

        .floating-badge.badge-2 {
            top: 45%;
            right: -10%;
        }

        .floating-badge.badge-3 {
            bottom: 15%;
            right: 5%;
        }

        /* How It Works Section */
        .how-it-works {
            background: var(--bg-cream);
            padding: 5rem 0;
        }

        .how-it-works h2 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(2rem, 4vw, 2.75rem);
            font-weight: 400;
            text-align: center;
            color: var(--text-primary);
            margin-bottom: 4rem;
        }

        .step-item {
            text-align: center;
            position: relative;
        }

        .step-number {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 4rem;
            font-style: italic;
            color: var(--primary);
            opacity: 0.8;
            line-height: 1;
            margin-bottom: 1rem;
        }

        .step-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        .step-description {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.6;
            max-width: 280px;
            margin: 0 auto;
        }

        .step-arrow {
            color: var(--primary);
            opacity: 0.4;
            font-size: 2rem;
            position: absolute;
            top: 2rem;
            right: -1rem;
        }

        /* Features Section */
        .features-v2 {
            background: var(--bg-white);
            padding: 5rem 0;
        }

        .feature-card {
            background: var(--bg-cream);
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
            border: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .feature-icon-v2 {
            width: 48px;
            height: 48px;
            background: var(--primary-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .feature-card h3 {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            font-size: 0.95rem;
            color: var(--text-secondary);
            margin: 0;
        }

        /* Footer */
        .footer-v2 {
            background: var(--text-primary);
            color: white;
            padding: 3rem 0 2rem;
        }

        .footer-v2 .footer-brand {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .footer-v2 .footer-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        .footer-v2 .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .footer-v2 .footer-links a:hover {
            color: white;
        }

        .footer-v2 hr {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 2rem 0;
        }

        .footer-v2 .copyright {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Form Styles */
        .form-control-v2 {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.2s;
            background: var(--bg-white);
        }

        .form-control-v2:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(61, 139, 139, 0.1);
            outline: none;
        }

        .form-label-v2 {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        /* Cards V2 */
        .card-v2 {
            background: var(--bg-white);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card-v2 .card-header {
            background: var(--bg-white);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem 2rem;
        }

        .card-v2 .card-body {
            padding: 2rem;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-v2 {
                padding: 3rem 0;
                min-height: auto;
            }

            .hero-image-container {
                margin-top: 3rem;
            }

            .floating-badge {
                display: none;
            }

            .step-arrow {
                display: none;
            }
        }

        @media (max-width: 767px) {
            .navbar-v2 .nav-link {
                padding: 0.75rem 0;
            }

            .hero-v2 h1 {
                font-size: 2rem;
            }

            .step-item {
                margin-bottom: 2rem;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar-v2">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('home.v2') }}" class="navbar-brand">
                    <span class="brand-icon">+</span>
                    Medi<span style="font-weight: 400;">Plus</span>
                </a>

                <div class="d-none d-md-flex align-items-center gap-4">
                    <a href="{{ route('home.v2') }}" class="nav-link">Home</a>
                    <a href="{{ route('home.v2') }}#how-it-works" class="nav-link">How It Works</a>
                    <a href="{{ route('home.v2') }}#features" class="nav-link">Features</a>
                    <a href="{{ route('contact.v2') }}" class="btn-cta">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Request Account
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="btn d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Mobile Nav -->
            <div class="collapse d-md-none mt-3" id="mobileNav">
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('home.v2') }}" class="nav-link">Home</a>
                    <a href="{{ route('home.v2') }}#how-it-works" class="nav-link">How It Works</a>
                    <a href="{{ route('home.v2') }}#features" class="nav-link">Features</a>
                    <a href="{{ route('contact.v2') }}" class="btn-cta mt-2">Request Account</a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer-v2">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="footer-brand">Medi+</div>
                    <p class="footer-text">Professional healthcare management system designed for modern medical facilities.</p>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h6 class="mb-3">Quick Links</h6>
                    <div class="footer-links d-flex flex-column gap-2">
                        <a href="{{ route('home.v2') }}">Home</a>
                        <a href="{{ route('contact.v2') }}">Apply Now</a>
                        <a href="{{ route('login') }}">Patient Login</a>
                    </div>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h6 class="mb-3">Staff</h6>
                    <div class="footer-links d-flex flex-column gap-2">
                        <a href="{{ route('doctor.login') }}">Doctor Portal</a>
                        <a href="{{ route('login') }}">Admin Login</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h6 class="mb-3">Contact</h6>
                    <div class="footer-text">
                        <p class="mb-1">📧 support@mediplus.com</p>
                        <p class="mb-1">📞 +1 (555) 123-4567</p>
                        <p class="mb-0">📍 123 Medical Center Drive</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="copyright">© {{ date('Y') }} MediPlus. All rights reserved.</span>
                <div class="footer-links d-flex gap-3">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>