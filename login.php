<?php
include('includes/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
    
    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_regenerate_id(); // Regenerate session ID to prevent session fixation
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            
            if ($row['role'] == 'admin') {
                header("location: admin/index.php");
            } else {
                header("location: customer/index.php");
            }
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No user found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
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
        .navbar {
            background: rgba(0, 0, 0, 0.7);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <video autoplay loop muted id="video-background">
        <source src="assets/images/bg.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Tourism Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="card mt-5">
        <div class="welcome-words">
            <h2>Welcome to Tourism Portal</h2>
            <p>Log in to access your dashboard.</p>
        </div>
        <div class="card-body">
            <div class="card-header text-center display-5">User Login</div>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <p>Don't have an account? <a href="register.php">Register Here</a></p>
                <button type="submit" class="btn btn-success">Login</button>
            </form>
            <?php if(isset($error)) { echo "<div class='alert alert-danger mt-3'>$error</div>"; } ?>
        </div>
    </div>
    
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
