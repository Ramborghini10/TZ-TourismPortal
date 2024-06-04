<?php
// session_start();
// if (!isset($_SESSION['loggedin'])) {
//     header("location: ../login.php");
//     exit;
// }
include('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    $sql = "INSERT INTO destinations (name, description, location) VALUES ('$name', '$description', '$location')";

    if ($conn->query($sql) === TRUE) {
        header("location: manage_destinations.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

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
    <h2>Add Destination</h2>
    <form action="create_destination.php" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Destination</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
