<?php
include('../includes/session.php');
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $tour_id = $_POST['tour_id'];
    $booking_date = $_POST['booking_date'];
    $status = $_POST['status'];

    $sql = "UPDATE bookings SET user_id=?, tour_id=?, booking_date=?, status=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissi", $user_id, $tour_id, $booking_date, $status, $id);
    $stmt->execute();

    header('Location: manage_bookings.php');
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM bookings WHERE id=$id");
$booking = $result->fetch_assoc();

include('includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-edit"></i> Edit Booking</h2>
        </div>
        <div class="card-body">
            <form action="edit_booking.php?id=<?php echo $id; ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
                <div class="form-group">
                    <label for="user_id"><i class="fas fa-user"></i> User</label>
                    <select name="user_id" class="form-control" required>
                        <?php
                        $users_result = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS full_name FROM users");
                        while ($user = $users_result->fetch_assoc()) {
                            $selected = $user['id'] == $booking['user_id'] ? 'selected' : '';
                            echo "<option value='" . $user['id'] . "' $selected>" . $user['full_name'] . "</option>";
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
                            $selected = $tour['id'] == $booking['tour_id'] ? 'selected' : '';
                            echo "<option value='" . $tour['id'] . "' $selected>" . $tour['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="booking_date"><i class="fas fa-calendar-alt"></i> Booking Date</label>
                    <input type="date" name="booking_date" class="form-control" value="<?php echo $booking['booking_date']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="status"><i class="fas fa-info-circle"></i> Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending" <?php echo $booking['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="confirmed" <?php echo $booking['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="canceled" <?php echo $booking['status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
