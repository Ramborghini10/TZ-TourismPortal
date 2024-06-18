<?php
include('../includes/session.php');
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $destination_id = $_POST['destination_id'];
    $name = $_POST['name'];
    $itinerary = $_POST['itinerary'];
    $price = $_POST['price'];

    $sql = "UPDATE tours SET destination_id=?, name=?, itinerary=?, price=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issdi", $destination_id, $name, $itinerary, $price, $id);
    $stmt->execute();

    header('Location: manage_tours.php');
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM tours WHERE id=$id");
$tour = $result->fetch_assoc();

include('includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-edit"></i> Edit Tour</h2>
        </div>
        <div class="card-body">
            <form action="edit_tour.php?id=<?php echo $id; ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $tour['id']; ?>">
                <div class="form-group">
                    <label for="destination_id"><i class="fas fa-map-signs"></i> Destination</label>
                    <select name="destination_id" class="form-control" required>
                        <?php
                        $destinations_result = $conn->query("SELECT * FROM destinations");
                        while ($destination = $destinations_result->fetch_assoc()) {
                            $selected = $destination['id'] == $tour['destination_id'] ? 'selected' : '';
                            echo "<option value='" . $destination['id'] . "' $selected>" . $destination['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name"><i class="fas fa-tag"></i> Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $tour['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="itinerary"><i class="fas fa-align-left"></i> Itinerary</label>
                    <textarea name="itinerary" class="form-control"><?php echo $tour['itinerary']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="price"><i class="fas fa-dollar-sign"></i> Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $tour['price']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
