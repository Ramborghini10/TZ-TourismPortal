<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            height: 100%;
            background: #f8f9fa;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: fixed;
            top: 56px; /* Height of the navbar */
            bottom: 0;
        }
        .sidebar a {
            font-size: 1.1em;
            margin: 10px 0;
        }
        .content {
            margin-left: 250px;
            flex: 1;
            padding: 20px;
        }
        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Tourism Portal Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="sidebar">
        <h4>Tourism Portal Admin</h4>
        <nav class="nav flex-column">
            <a class="nav-link active" aria-current="page" href="dashboard.php">Dashboard</a>
            <a class="nav-link" href="manage_users.php">Manage Users</a>
            <a class="nav-link" href="manage_destinations.php">Manage Destinations</a>
            <a class="nav-link" href="manage_bookings.php">Manage Bookings</a>
            <a class="nav-link" href="reports.php">Reports</a>
            <a class="nav-link" href="settings.php">Settings</a>
            <a class="nav-link" href="logout.php">Logout</a>
        </nav>
    </div>