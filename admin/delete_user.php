<?php
include('../includes/session.php');
include('../includes/db.php');

$id = $_GET['id'];

if (isset($id)) {
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        header('Location: manage_users.php?msg=User deleted successfully');
    } else {
        header('Location: manage_users.php?msg=User not found or could not be deleted');
    }
} else {
    header('Location: manage_users.php?msg=Invalid user ID');
}
?>
