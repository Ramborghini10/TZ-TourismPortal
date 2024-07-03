<?php include 'includes/header.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report New Attraction</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .form-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            /* transform: translateY(-50%); */
            font-size: 1.2rem;
            color: cadetblue;
        }
        .form-control {
            padding-left: 35px;
        }
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }
        .btn-submit {
            width: 100%;
            
        }
    </style>
    <script>
        function validateForm() {
            let phone = document.getElementById("phone").value;
            let email = document.getElementById("email").value;
            let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let phonePattern = /^[0-9]{10,15}$/;

            if (!phonePattern.test(phone)) {
                alert("Please enter a valid phone number.");
                return false;
            }

            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="bi bi-flag-fill form-icon"></i> Report New Attraction</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $fullName = htmlspecialchars($_POST['fullName']);
                            $occupation = htmlspecialchars($_POST['occupation']);
                            $identity = htmlspecialchars($_POST['identity']);
                            $attractionType = htmlspecialchars($_POST['attractionType']);
                            $description = htmlspecialchars($_POST['description']);
                            $phone = htmlspecialchars($_POST['phone']);
                            $email = htmlspecialchars($_POST['email']);
                            $location = htmlspecialchars($_POST['location']);

                            // Handle file upload
                            $uploadDir = 'assets/images/';
                            $uploadFile = $uploadDir . basename($_FILES['media']['name']);

                            if (move_uploaded_file($_FILES['media']['tmp_name'], $uploadFile)) {
                                // File uploaded successfully, continue with database insertion
                                $mediaPath = $uploadFile;
                                $mediaType = pathinfo($mediaPath, PATHINFO_EXTENSION);

                                // Insert data into database using prepared statements
                               include 'includes/db.php';
                                $stmt = $conn->prepare("INSERT INTO new_attractions (full_name, occupation, identity, attraction_type, description, phone, email, location, media, media_type, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())");
                                $stmt->bind_param("ssssssssss", $fullName, $occupation, $identity, $attractionType, $description, $phone, $email, $location, $mediaPath, $mediaType);

                                if ($stmt->execute()) {
                                    echo "<div class='alert alert-success'>Attraction reported successfully!</div>";
                                } else {
                                    echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
                                }

                                $stmt->close();
                                $conn->close();
                            } else {
                                echo "<div class='alert alert-danger'>Failed to upload media file.</div>";
                            }
                        }
                        ?>
                        <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="bi bi-person-fill form-icon"></i>
                                        <label for="fullName">Full Name</label>
                                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                                    </div>
                                    <div class="form-group">
                                        <i class="bi bi-briefcase-fill form-icon"></i>
                                        <label for="occupation">Occupation</label>
                                        <input type="text" class="form-control" id="occupation" name="occupation" required>
                                    </div>
                                    <div class="form-group">
                                        <i class="bi bi-card-text form-icon"></i>
                                        <label for="identity">Identity (e.g., NIDA)</label>
                                        <input type="text" class="form-control" id="identity" name="identity" required>
                                    </div>
                                    <div class="form-group">
                                        <i class="bi bi-phone-fill form-icon"></i>
                                        <label for="phone">Phone</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                    <div class="form-group">
                                        <i class="bi bi-envelope-fill form-icon"></i>
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <i class="bi bi-geo-alt-fill form-icon"></i>
                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" id="location" name="location" required>
                                    </div>
                                    <div class="form-group">
                                        <i class="bi bi-tag-fill form-icon"></i>
                                        <label for="attractionType">Type of Attraction</label>
                                        <select class="form-control" id="attractionType" name="attractionType" required>
                                            <option value="">Select Attraction Type</option>
                                            <option value="Natural">Natural</option>
                                            <option value="Historical">Historical</option>
                                            <option value="Cultural">Cultural</option>
                                            <option value="Adventure">Adventure</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <i class="bi bi-card-text form-icon"></i>
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <i class="bi bi-upload form-icon"></i>
                                        <label for="media">Upload Media (Image or Video)</label>
                                        <input type="file" class="form-control" id="media" name="media" accept="image/*, video/*" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-submit"><i class="bi bi-save"></i> Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
