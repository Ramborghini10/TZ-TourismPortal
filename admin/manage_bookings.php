<?php
// session_start();
// if (!isset($_SESSION['loggedin'])) {
//     header("location: ../login.php");
//     exit;
// }
include('../includes/db.php');

// Fetch bookings from the database
$sql = "SELECT bookings.id, users.username, destinations.name as destination, bookings.booking_date, bookings.status 
        FROM bookings
        JOIN users ON bookings.user_id = users.id
        JOIN destinations ON bookings.destination_id = destinations.id";
$result = $conn->query($sql);
// include('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
include('includes/header.php');
include('includes/sidebar.php');
?>
<div class="container mt-5">
    <h2>Manage Bookings</h2>
    <a href="create_booking.php" class="btn btn-primary mb-3">Add Booking</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Destination</th>
                <th>Booking Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['destination']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <a href="edit_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="delete_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>
