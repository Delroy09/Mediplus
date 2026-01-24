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
            background-color: #9fc5e8;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .dashboard-sidebar {
            background-color: #2b5797;
            min-height: 100vh;
            padding: 0;
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            color: white;
        }

        .sidebar-brand {
            background-color: #ffffff;
            margin: 0;
            padding: 12px;
            text-align: center;
            font-weight: bold;
            border-radius: 6px;
            color: #000;
        }

        .sidebar-nav {
            padding: 0;
        }

        .sidebar-nav a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            padding: 12px;
            margin: 5px 10px;
            border-radius: 6px;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: #1d3f73;
        }

        .sidebar-logout {
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .sidebar-logout .btn {
            background-color: #6fa8dc;
            color: #fff;
            width: calc(100% - 30px);
            margin: 15px;
            padding: 8px;
            border-radius: 6px;
            font-size: 13px;
            border: none;
        }

        .sidebar-logout .btn:hover {
            background-color: #5a8fc7;
        }

        .dashboard-content {
            margin-left: 220px;
            padding: 0;
        }

        .main-box {
            background-color: #ffffff;
            border-radius: 6px;
            padding: 15px;
            margin: 20px;
        }

        .top-bar {
            border-bottom: 1px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-pic {
            background-color: #e7f3ff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 13px;
        }

        .content-box {
            background-color: #e7f3ff;
            border-radius: 6px;
            padding: 30px;
            margin-top: 15px;
        }

        .info-row {
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
        }

        .info-row strong {
            margin-right: 5px;
        }

        .status-admitted {
            background-color: #4491C0;
            color: #ffffff;
        }

        .status-surgery {
            background-color: #EAA800;
            color: #ffffff;
        }

        .status-discharged {
            background-color: #5DCD98;
            color: #ffffff;
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
            <div class="main-box">
                <!-- Top Bar -->
                <div class="top-bar">
                    <div>
                        <strong>User</strong> &nbsp; | &nbsp; <span>@yield('page-title')</span>
                    </div>
                    <div class="profile-pic">Profile Pic Here</div>
                </div>

                <!-- Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>