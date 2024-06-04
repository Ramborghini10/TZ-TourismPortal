<?php
include('../includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("location: ../admin/manage_users.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
