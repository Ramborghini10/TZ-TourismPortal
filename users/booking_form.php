<?php
include 'includes/session.php';
include 'header.php';
include 'includes/db.php';

// Initialize variables
$error_message = '';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;
    $tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : null;
    $booking_date = isset($_POST['booking_date']) ? $_POST['booking_date'] : null;

    if (!$user_id || !$tour_id || !$booking_date) {
        $error_message = "Please fill in all required fields.";
    } else {
        // Insert booking into database
        $status = 'pending';
        $sql = "INSERT INTO bookings (user_id, tour_id, booking_date, status) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("iiss", $user_id, $tour_id, $booking_date, $status);
            if ($stmt->execute()) {
                // Redirect to confirmation page after successful booking
                header('Location: booking_confirmation.php');
                exit;
            } else {
                // Handle execute error
                $error_message = "Error executing booking: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // Handle prepare error
            $error_message = "Error preparing statement: " . $conn->error;
        }
    }
}

// Fetch tours for the dropdown
$tours_result = $conn->query("SELECT id, name FROM tours");

?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-calendar-alt"></i> Book a Tour</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="booking_form.php" method="POST">
                <div class="form-group">
                    <label for="user_id"><i class="fas fa-user"></i> User</label>
                    <select name="user_id" class="form-control" required>
                        <?php
                        $users_result = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS full_name FROM users");
                        while ($user = $users_result->fetch_assoc()) {
                            echo "<option value='" . $user['id'] . "'>" . $user['full_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tour_id"><i class="fas fa-map-signs"></i> Tour</label>
                    <select name="tour_id" class="form-control" required>
                        <?php
                        while ($tour = $tours_result->fetch_assoc()) {
                            echo "<option value='" . $tour['id'] . "'>" . $tour['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="booking_date"><i class="fas fa-calendar-alt"></i> Booking Date</label>
                    <input type="date" name="booking_date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Book Tour</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
