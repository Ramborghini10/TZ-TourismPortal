<?php
include('../includes/db.php');

$id = $_GET['id'];

if (isset($id)) {
    $sql = "DELETE FROM bookings WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        header('Location: manage_bookings.php?msg=Booking deleted successfully');
    } else {
        header('Location: manage_bookings.php?msg=Booking not found or could not be deleted');
    }
} else {
    header('Location: manage_bookings.php?msg=Invalid booking ID');
}
?>
