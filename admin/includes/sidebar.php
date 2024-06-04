
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
        }
        .sidebar a {
            font-size: 1.1em;
            margin: 10px 0;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
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