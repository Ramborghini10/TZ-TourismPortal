<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Tourism Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
        <a class="navbar-brand" href="index.php">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Welcome, Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Side Navigation Bar -->
    <div class="d-flex">
        <nav class="nav flex-column bg-light p-3" style="min-height: 100vh; width: 250px;">
            <a class="nav-link active" href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a class="nav-link" href="manage_categories.php"><i class="fas fa-tachometer-alt"></i> Destination Categories</a>
            <a class="nav-link" href="manage_destinations.php"><i class="fas fa-map-marker-alt"></i> Manage Destinations</a>
            <a class="nav-link" href="manage_tours.php"><i class="fas fa-suitcase-rolling"></i> Manage Tours</a>
            <a class="nav-link" href="manage_bookings.php"><i class="fas fa-calendar-check"></i> Manage Bookings</a>
            <a class="nav-link" href="manage_new_attractions.php"><i class="fas fa-calendar-check"></i> Manage New Attractions</a>
            <a class="nav-link" href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a>
            <a class="nav-link" href="admin_profile.php"><i class="fas fa-user"></i> Profile</a>
            <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
        <div class="content p-4" style="width: 100%;">
            <!-- Your main content goes here -->
       