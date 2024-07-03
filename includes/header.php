<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Tourism Portal</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .navbar {
            background: rgba(0, 123, 255, 0.9); /* Change background color */
            font-size: 1.2rem; /* Increase font size */
            padding: 1rem 2rem; /* Add padding */
        }
        .navbar-brand {
            font-size: 2rem; /* Larger brand text */
            font-weight: bold; /* Bold brand text */
            color: #fff !important; /* White brand text */
        }
        .navbar-nav .nav-link {
            color: #fff !important; /* White nav links */
            margin-right: 1rem; /* Space between links */
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
            color: #ffd700 !important; /* Gold hover color */
        }
        .navbar-nav .nav-link.active {
            color: #ffd700 !important; /* Gold active color */
        }
        .navbar-toggler-icon {
            color: #fff; /* White icon */
        }
        .nav-item i {
            margin-right: 0.5rem; /* Space between icon and text */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="bi bi-geo-alt-fill"></i> Tourism Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php"><i class="bi bi-house-door-fill"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="attractions.php"><i class="bi bi-binoculars-fill"></i> Attractions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="report_attractions.php"><i class="bi bi-flag-fill"></i> Report Attraction</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php"><i class="bi bi-person-plus-fill"></i> Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JavaScript -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> -->
