<?php
// session_start();
// if (!isset($_SESSION['loggedin'])) {
//     header("location: ../login.php");
//     exit;
// }
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $destination_id = $_POST['destination_id'];
    $booking_date = $_POST['booking_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO bookings (user_id, destination_id, booking_date, status) VALUES ('$user_id', '$destination_id', '$booking_date', '$status')";

    if ($conn->query($sql) === TRUE) {
        header("location: manage_bookings.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql_users = "SELECT user_id, username FROM users";
$result_users = $conn->query($sql_users);

$sql_destinations = "SELECT id, name FROM destinations";
$result_destinations = $conn->query($sql_destinations);

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
    <h2>Add Booking</h2>
    <form action="add_booking.php" method="post">
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <?php while ($user = $result_users->fetch_assoc()) : ?>
                <option value="<?php echo $user['user_id']; ?>"><?php echo $user['username']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="destination_id" class="form-label">Destination</label>
            <select class="form-control" id="destination_id" name="destination_id" required>
                <?php while ($destination = $result_destinations->fetch_assoc()) : ?>
                <option value="<?php echo $destination['destination_id']; ?>"><?php echo $destination['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="booking_date" class="form-label">Booking Date</label>
            <input type="date" class="form-control" id="booking_date" name="booking_date" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="confirmed">Confirmed</option>
                <option value="pending">Pending</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Booking</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
