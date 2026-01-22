<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #9fc5e8;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            background-color: #2b5797;
            min-height: 100vh;
            width: 220px;
        }

        .sidebar h4 {
            background-color: #ffffff;
            margin: 0;
            padding: 12px;
            text-align: center;
            font-weight: bold;
            border-radius: 6px;
        }

        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            padding: 12px;
            margin: 5px 10px;
            border-radius: 6px;
            font-size: 14px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #1d3f73;
        }

        .logout-btn {
            background-color: #6fa8dc;
            color: #fff;
            text-align: center;
            margin: 15px;
            padding: 8px;
            border-radius: 6px;
            font-size: 13px;
        }

        .main-box {
            background-color: #ffffff;
            border-radius: 6px;
            padding: 15px;
        }

        .content-box {
            background-color: #e7f3ff;
            border-radius: 6px;
            padding: 30px;
            margin-top: 15px;
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

        .info-row {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 5px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-auto sidebar p-0">
            <h4>medi+</h4>

            <a href="#">Dashboard</a>
            <a href="#">Edit Profile</a>
            <a href="#">My Schedule</a>
            <a href="#" class="active">Manage Account</a>

            <div class="logout-btn">LOGOUT</div>
        </div>

        <!-- Main Content -->
        <div class="col p-4">
            <div class="main-box">

                <!-- Top Bar -->
                <div class="top-bar">
                    <div>
                        <strong>User</strong> &nbsp; | &nbsp; <span>Manage Account</span>
                    </div>
                    <div class="profile-pic">Profile Pic Here</div>
                </div>

                <!-- Content -->
                <div class="content-box text-center">

                    <div class="info-row">
                        <strong>Full Name:</strong> &nbsp; Nash Dsouza
                    </div>

                    <div class="info-row">
                        <strong>Associated Email Address:</strong> &nbsp; nds@gmail.com
                    </div>

                    <div class="info-row">
                        <strong>Patient Status:</strong> &nbsp; Discharged
                    </div>

                    <br>

                    <button class="delete-btn">
                        Request Account Deletion
                    </button>

                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>
