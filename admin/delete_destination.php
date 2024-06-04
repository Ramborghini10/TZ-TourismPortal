<?php
include('../includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM destinations WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("location: manage_destinations.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
