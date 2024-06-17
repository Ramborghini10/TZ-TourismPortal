<?php
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $tour_id = $_POST['tour_id'];
    $booking_date = $_POST['booking_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO bookings (user_id, tour_id, booking_date, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $user_id, $tour_id, $booking_date, $status);
    $stmt->execute();

    header('Location: manage_bookings.php');
}

include('includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-plus"></i> Add New Booking</h2>
        </div>
        <div class="card-body">
            <form action="create_booking.php" method="POST">
                <div class="form-group">
                    <label for="user_id"><i class="fas fa-user"></i> User</label>
                    <select name="user_id" class="form-control" required>
                        <?php
                        $users_result = $conn->query("SELECT id, first_name, last_name FROM users");
                        while ($user = $users_result->fetch_assoc()) {
                            echo "<option value='" . $user['id'] . "'>" . $user['first_name'] . " " . $user['last_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tour_id"><i class="fas fa-map-signs"></i> Tour</label>
                    <select name="tour_id" class="form-control" required>
                        <?php
                        $tours_result = $conn->query("SELECT id, name FROM tours");
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
                <div class="form-group">
                    <label for="status"><i class="fas fa-info-circle"></i> Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Add Booking</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
