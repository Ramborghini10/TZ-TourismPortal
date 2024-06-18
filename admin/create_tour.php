<?php
include('../includes/session.php');
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destination_id = $_POST['destination_id'];
    $name = $_POST['name'];
    $itinerary = $_POST['itinerary'];
    $price = $_POST['price'];

    $sql = "INSERT INTO tours (destination_id, name, itinerary, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issd", $destination_id, $name, $itinerary, $price);
    $stmt->execute();

    header('Location: manage_tours.php');
}

include('includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-plus"></i> Add New Tour</h2>
        </div>
        <div class="card-body">
            <form action="create_tour.php" method="POST">
                <div class="form-group">
                    <label for="destination_id"><i class="fas fa-map-signs"></i> Destination</label>
                    <select name="destination_id" class="form-control" required>
                        <?php
                        $destinations_result = $conn->query("SELECT * FROM destinations");
                        while ($destination = $destinations_result->fetch_assoc()) {
                            echo "<option value='" . $destination['id'] . "'>" . $destination['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name"><i class="fas fa-tag"></i> Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="itinerary"><i class="fas fa-align-left"></i> Itinerary</label>
                    <textarea name="itinerary" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="price"><i class="fas fa-dollar-sign"></i> Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Add Tour</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
