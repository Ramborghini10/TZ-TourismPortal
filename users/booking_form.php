<?php
include 'includes/session.php';
include('header.php');
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $tour_id = $_POST['tour_id'];
    $booking_date = $_POST['booking_date'];
    $status = 'pending';

    $sql = "INSERT INTO bookings (user_id, tour_id, booking_date, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $user_id, $tour_id, $booking_date, $status);
    $stmt->execute();

    header('Location: booking_confirmation.php');
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

<?php include('../includes/footer.php'); ?>
