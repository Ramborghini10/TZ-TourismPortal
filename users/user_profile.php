<?php
// Database connection
include('../includes/db.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch user details from the database using email
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_details = $result->fetch_assoc();
    // Extract user details
    $id = $user_details['id'];
    $first_name = $user_details['first_name'];
    $last_name = $user_details['last_name'];
    $email = $user_details['email'];
    $phone = $user_details['phone'];
    $profile_pic = $user_details['profile_pic']; // Assuming profile_pic is a file path or URL
    $role = $user_details['role'];
    $created_at = $user_details['created_at'];
    $country = $user_details['country'];
    $ip_address = $user_details['ip_address'];

    // Format created_at date if needed
    $created_at_formatted = date('F j, Y, g:i a', strtotime($created_at));
} else {
    echo "No user found with this email.";
    exit();
}
$stmt->close();

// Fetch user's booking history
$booking_history = [];
$sql_bookings = "SELECT b.booking_date, t.name AS tour_name
                FROM bookings b
                INNER JOIN tours t ON b.tour_id = t.id
                WHERE b.user_id = ?";
$stmt_bookings = $conn->prepare($sql_bookings);
$stmt_bookings->bind_param("i", $id);
$stmt_bookings->execute();
$result_bookings = $stmt_bookings->get_result();

while ($row = $result_bookings->fetch_assoc()) {
    $booking_history[] = $row;
}
$stmt_bookings->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .profile-card {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
        }
        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-info {
            text-align: center;
        }
        .profile-info h3 {
            margin-bottom: 10px;
        }
        .profile-info p {
            color: #666;
        }
    </style>
</head>
<body>
    <?php include 'header.php' ?>
    <div class="container">
        <div class="profile-card">
            <div class="profile-picture">
                <?php if (!empty($profile_pic)) : ?>
                    <img src="<?php echo $profile_pic; ?>" alt="Profile Picture">
                <?php else : ?>
                    <img src="https://via.placeholder.com/150" alt="Placeholder Image">
                <?php endif; ?>
            </div>
            <div class="profile-info">
                <h3><?php echo $first_name . " " . $last_name; ?></h3>
                <p><?php echo $email; ?></p>
                <p><?php echo $phone; ?></p>
                <p><?php echo "Role: " . $role; ?></p>
                <p><?php echo "Country: " . $country; ?></p>
                <p><?php echo "IP Address: " . $ip_address; ?></p>
                <p><?php echo "Joined: " . $created_at_formatted; ?></p>
            </div>
        </div>

        <div class="mt-4">
            <h4>Booking History</h4>
            <ul>
                <?php foreach ($booking_history as $booking) : ?>
                    <li><?php echo $booking['booking_date'] . " - " . $booking['tour_name']; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Bootstrap and Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
