<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Medi+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('global.css') }}">
    <style>
        body {
            background: #E8F1F8;
            min-height: 100vh;
        }

        .dashboard-sidebar {
            background: linear-gradient(180deg, #4A7BA7 0%, #3A5F7D 100%);
            min-height: 100vh;
            padding: 0;
            position: fixed;
            left: 0;
            top: 0;
            width: 200px;
            color: white;
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav a {
            display: block;
            padding: 0.875rem 1.5rem;
            color: white;
            text-decoration: none;
            transition: all 0.2s;
            border-bottom: 2px solid transparent;
            margin-bottom: 0.5rem;
        }

        .sidebar-nav a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav a.active {
            border-bottom: 2px solid white;
            background: rgba(255, 255, 255, 0.15);
        }

        .sidebar-logout {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
        }

        .sidebar-logout .btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 2rem;
            border-radius: 8px;
        }

        .sidebar-logout .btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .dashboard-content {
            margin-left: 200px;
            padding: 0;
        }

        .content-header {
            background: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #dee2e6;
            font-size: 1.25rem;
            font-weight: 500;
            color: #333;
        }

        .content-body {
            padding: 2rem;
        }

        .info-card {
            background: #D4E7F5;
            border-radius: 12px;
            padding: 2.5rem;
            border: none;
        }

        .info-row {
            display: flex;
            margin-bottom: 1.5rem;
            align-items: center;
        }

        .info-label {
            font-weight: 500;
            color: #333;
            min-width: 200px;
            text-align: right;
            margin-right: 2rem;
        }

        .info-value {
            color: #333;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            min-width: 250px;
        }

        .info-value.readonly {
            background: white;
            border: 1px solid #dee2e6;
        }

        @media (max-width: 768px) {
            .dashboard-sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }

            .dashboard-content {
                margin-left: 0;
            }

            .sidebar-logout {
                position: relative;
                margin-top: 2rem;
                bottom: auto;
                left: auto;
                transform: none;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="dashboard-sidebar">
            <div class="sidebar-brand">
                medi+
            </div>
            <nav class="sidebar-nav">
                @yield('sidebar-menu')
            </nav>
            <div class="sidebar-logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn">LOGOUT</button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="dashboard-content flex-fill">
            <div class="content-header">
                User | @yield('page-title')
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>