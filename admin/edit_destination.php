<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("location: ../login.php");
    exit;
}
include('../includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM destinations WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        header("location: manage_destinations.php");
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    $sql = "UPDATE destinations SET name='$name', description='$description', location='$location' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("location: manage_destinations.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("location: manage_destinations.php");
}

include('includes/header.php');
?>

<div class="container mt-5">
    <h2>Edit Destination</h2>
    <form action="edit_destination.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required><?php echo $row['description']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo $row['location']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
