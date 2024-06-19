<?php
include('includes/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $role = 'user'; // Default role as 'user'
    $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, phone, country, role, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $password, $phone, $country, $role, $ip_address);
    
    if ($stmt->execute()) {
        // Registration success
        header("location: login.php");
        exit;
    } else {
        $error = "Registration failed: " . htmlspecialchars($stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        #video-background {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1000;
            overflow: hidden;
        }
        .card {
            display: flex;
            flex-direction: row;
            background: rgba(255, 255, 255, 0.9); /* Add opacity to make the card content readable */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .welcome-words {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url('assets/images/login.jpeg');
            background-size: cover;
            background-position: center;
            color: green;
            padding: 20px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px;
        }
        .card-header {
            color: green;
        }
    </style>
</head>
<body>
    <video autoplay loop muted id="video-background">
        <source src="assets/images/bg.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="card">
        <div class="welcome-words">
            <h2>Welcome to Tourism Portal</h2>
            <p>Register to access your dashboard.</p>
        </div>
        <div class="card-body">
            <div class="card-header text-center display-5">User Registration</div>
            <form action="register.php" method="post">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country">
                </div>
                <p>Already have an account? <a href="login.php">Login Here</a></p>
                <button type="submit" class="btn btn-success">Register</button>
            </form>
            <?php if(isset($error)) { echo "<div class='alert alert-danger mt-3'>$error</div>"; } ?>
        </div>
    </div>
    
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
