<?php
include('includes/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT user_id, email, password, role FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            if ($row['role'] == 'admin') {
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                header("location: admin/index.php");
                exit;
            } else {
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                header("location: customer/index.php");
                exit;
            }
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
            background: rgba(255, 255, 255, 0.7); /* Add opacity to make the card content readable */
            padding: 20px;
            border-radius: 10px;
        }
        .card img {
            width: 50%;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .card-header{
            color:green;
        }
        .card-body {
            width: 50%;
            padding: 20px;
        }
        .welcome-words {
            background-image: url('assets/images/login.jpeg');
            background-size: cover;
            background-position: center;
            color: green;
            padding: 20px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
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
            <p>Log in to access the your dashboard.</p>
        </div>
        <div class="card-body">
            <div class="card-header text-center display-5 text-green">User Login</div>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-success">Login</button>
            </form>
            <?php if(isset($error)) { echo "<div class='alert alert-danger mt-3'>$error</div>"; } ?>
        </div>
    </div>
    
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
