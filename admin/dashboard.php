<?php
include('../includes/session.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="container mt-5">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="admin/manage_destinations.php" class="list-group-item list-group-item-action">Manage Destinations</a>
                    <a href="admin/manage_users.php" class="list-group-item list-group-item-action">Manage Users</a>
                    <a href="logout.php" class="list-group-item list-group-item-action">Logout</a>
                </div>
            </div>
            <div class="col-md-9">
                <h2>Dashboard</h2>
                <p>Here you can manage the tourism portal content.</p>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
