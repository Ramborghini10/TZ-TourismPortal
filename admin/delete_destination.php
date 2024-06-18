<?php
include('../includes/session.php');
include('../includes/db.php');

$id = $_GET['id'];

// Get the image file name so we can delete the image file
$result = $conn->query("SELECT image FROM destinations WHERE id=$id");
$row = $result->fetch_assoc();
$image = $row['image'];

// Delete the image file
if ($image) {
    $image_path = "../assets/images/" . $image;
    if (file_exists($image_path)) {
        unlink($image_path);
    }
}

// Delete the destination from the database
$sql = "DELETE FROM destinations WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header('Location: manage_destinations.php');
?>
