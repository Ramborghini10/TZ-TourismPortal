<?php
include('../includes/session.php');
include('../includes/db.php');

$id = $_GET['id'];

$sql = "DELETE FROM tours WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header('Location: manage_tours.php');
?>
