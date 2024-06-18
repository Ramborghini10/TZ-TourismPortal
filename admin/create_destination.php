<?php
include('../includes/session.php');
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $best_time_to_visit = $_POST['best_time_to_visit'];
    $activities = $_POST['activities'];
    $accommodations = $_POST['accommodations'];
    $average_cost = $_POST['average_cost'];
    $category_id = $_POST['category_id'];
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/";
        $image = basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }

    $sql = "INSERT INTO destinations (name, description, location, best_time_to_visit, activities, accommodations, average_cost, image, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssdsi", $name, $description, $location, $best_time_to_visit, $activities, $accommodations, $average_cost, $image, $category_id);
    $stmt->execute();

    header('Location: manage_destinations.php');
}

include('includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-map-marker-alt"></i> Add New Destination</h2>
        </div>
        <div class="card-body">
            <form action="create_destination.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name"><i class="fas fa-map-signs"></i> Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description"><i class="fas fa-align-left"></i> Description</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="location"><i class="fas fa-map"></i> Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="best_time_to_visit"><i class="fas fa-calendar-alt"></i> Best Time to Visit</label>
                    <input type="text" name="best_time_to_visit" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="activities"><i class="fas fa-futbol"></i> Activities</label>
                    <textarea name="activities" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="accommodations"><i class="fas fa-bed"></i> Accommodations</label>
                    <textarea name="accommodations" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="average_cost"><i class="fas fa-dollar-sign"></i> Average Cost</label>
                    <input type="number" step="0.01" name="average_cost" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="image"><i class="fas fa-image"></i> Image</label>
                    <input type="file" name="image" class="form-control-file" required>
                </div>
                <div class="form-group">
                    <label for="category_id"><i class="fas fa-tags"></i> Category</label>
                    <select name="category_id" class="form-control" required>
                        <?php
                        $categories_result = $conn->query("SELECT * FROM destination_categories");
                        while ($category = $categories_result->fetch_assoc()) {
                            echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Destination</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
