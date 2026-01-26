<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Medi+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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
            --sidebar-bg: #1F2937;
            --sidebar-hover: #374151;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-cream);
            color: var(--text-primary);
            font-size: 14px;
        }

        /* Sidebar */
        .sidebar-v2 {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            padding: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand a {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .sidebar-user {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-user-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .sidebar-user-info {
            flex: 1;
        }

        .sidebar-user-name {
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .sidebar-user-role {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            text-transform: capitalize;
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-nav-label {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.75rem 1.5rem 0.5rem;
        }

        .sidebar-nav a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            margin: 0.125rem 0.75rem;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .sidebar-nav a:hover {
            background: var(--sidebar-hover);
            color: white;
        }

        .sidebar-nav a.active {
            background: var(--primary);
            color: white;
        }

        .sidebar-nav a svg {
            width: 20px;
            height: 20px;
            opacity: 0.8;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-footer .btn-logout {
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .sidebar-footer .btn-logout:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #FCA5A5;
        }

        /* Main Content */
        .main-content-v2 {
            margin-left: 260px;
            min-height: 100vh;
        }

        .top-header {
            background: var(--bg-white);
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .content-area {
            padding: 2rem;
        }

        /* Cards */
        .card-v2 {
            background: var(--bg-white);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .card-v2 .card-header {
            background: var(--bg-white);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        .card-v2 .card-body {
            padding: 1.5rem;
        }

        /* Info Rows */
        .info-row-v2 {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .info-row-v2:last-child {
            border-bottom: none;
        }

        .info-row-v2 .label {
            width: 180px;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .info-row-v2 .value {
            flex: 1;
            color: var(--text-primary);
        }

        /* Tables */
        .table-v2 {
            width: 100%;
            border-collapse: collapse;
        }

        .table-v2 thead th {
            background: var(--bg-cream);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-secondary);
            border-bottom: 2px solid var(--border-color);
        }

        .table-v2 tbody td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .table-v2 tbody tr:hover {
            background: var(--bg-cream);
        }

        .table-v2 tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge-v2 {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-admitted {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .badge-surgery {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge-discharged {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-primary {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .badge-success {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-warning {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge-danger {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* Buttons */
        .btn-v2 {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .btn-v2-primary {
            background: var(--primary);
            color: white;
        }

        .btn-v2-primary:hover {
            background: var(--primary-dark);
            color: white;
        }

        .btn-v2-secondary {
            background: var(--bg-cream);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-v2-secondary:hover {
            background: var(--border-color);
        }

        .btn-v2-danger {
            background: #FEE2E2;
            color: #991B1B;
        }

        .btn-v2-danger:hover {
            background: #FECACA;
        }

        .btn-v2-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8rem;
        }

        /* Stats Cards */
        .stat-card {
            background: var(--bg-white);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .stat-card .stat-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Form Controls */
        .form-control-v2 {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s;
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
            font-size: 0.9rem;
        }

        /* Alerts */
        .alert-v2 {
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-v2-success {
            background: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-v2-error {
            background: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        /* Scrollable table */
        .scrollable-table {
            max-height: 400px;
            overflow-y: auto;
        }

        .scrollable-table thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-secondary);
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .sidebar-v2 {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar-v2.open {
                transform: translateX(0);
            }

            .main-content-v2 {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block !important;
            }
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar-v2" id="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('home.v2') }}">
                <span class="brand-icon">+</span>
                MediPlus
            </a>
        </div>

        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">Admin</div>
                <div class="sidebar-user-role">Full Access</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-nav-label">Menu</div>
            @yield('sidebar-menu')
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content-v2">
        <header class="top-header">
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <h1 class="page-title">@yield('page-title')</h1>
            </div>
            <div class="header-actions">
                @yield('header-actions')
            </div>
        </header>

        <div class="content-area">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>