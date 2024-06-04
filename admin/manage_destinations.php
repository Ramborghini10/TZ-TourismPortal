<?php
// session_start();
// if (!isset($_SESSION['loggedin'])) {
//     header("location: ../login.php");
//     exit;
// }
include('../includes/db.php');

// Fetch destinations from the database
$sql = "SELECT * FROM destinations";
$result = $conn->query($sql);


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
    <h2>Manage Destinations</h2>
    <a href="create_destination.php" class="btn btn-primary mb-3">Add Destination</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['destination_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td>
                    <a href="edit_destination.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="delete_destination.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this destination?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
