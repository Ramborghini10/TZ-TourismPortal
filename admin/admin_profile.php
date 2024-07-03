<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include('../includes/db.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$admin_details = [];

// Fetch admin details from the database using email
$sql = "SELECT id, first_name, last_name, email, phone FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $admin_details = $result->fetch_assoc();
} else {
    echo "No admin found with this email.";
    exit();
}
$stmt->close();

// Handle form submission for updating admin details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Validate and sanitize input
    $name = htmlspecialchars(strip_tags($name));
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(strip_tags($phone));

    // Update password if provided
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
        $sql = "UPDATE users SET first_name = ?, email = ?, phone = ?, password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $phone, $password, $email);
    } else {
        $sql = "UPDATE users SET first_name = ?, email = ?, phone = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $phone, $email);
    }

    if ($stmt->execute()) {
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Error updating profile: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
}
?>

    <style>
       
        .card {
            margin-left: 300px;
            width: 100%;
            max-width: 500px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            background: #ffffff;
        }
        .form-icon {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        .btn-submit {
            width: 100%;
        }
    </style>

<?php include 'includes/sidebar.php'; ?>

    <div class="card">
        <h3 class="text-center">Admin Profile</h3>
        <?php if (isset($success_message)) { echo "<div class='alert alert-success'>$success_message</div>"; } ?>
        <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $admin_details['first_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $admin_details['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $admin_details['phone']; ?>">
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
            </div>
            <button type="submit" class="btn btn-primary btn-submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
