<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// session_start();
// if (!isset($_SESSION['loggedin'])) {
//     header("location: ../login.php");
//     exit;
// }
include('../includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        header("location: manage_users.php");
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name='$name', username='$username', email='$email', phone='$phone', role='$role' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("location: manage_users.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("location: manage_users.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <form action="edit_user.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" id="role" name="role">
                    <option value="admin" <?php if ($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="manager" <?php if ($row['role'] == 'manager') echo 'selected'; ?>>Manager</option>
                    <option value="content_creator" <?php if ($row['role'] == 'content_creator') echo 'selected'; ?>>Content Creator</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
