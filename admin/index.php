<?php include('includes/sidebar.php'); ?>
<div class="container">
    <h2>Admin Dashboard</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Manage Destinations</h5>
                    <p class="card-text">Add, edit, and delete destinations.</p>
                    <a href="manage_destinations.php" class="btn btn-light">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Manage Tours</h5>
                    <p class="card-text">Add, edit, and delete tours.</p>
                    <a href="manage_tours.php" class="btn btn-light">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Manage Bookings</h5>
                    <p class="card-text">View and manage bookings.</p>
                    <a href="manage_bookings.php" class="btn btn-light">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">View and manage users.</p>
                    <a href="manage_users.php" class="btn btn-light">Go</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('../includes/admin_footer.php'); ?>
