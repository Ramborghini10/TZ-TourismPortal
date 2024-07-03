<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $best_time_to_visit = $_POST['best_time_to_visit'];
    $activities = $_POST['activities'];
    $accommodations = $_POST['accommodations'];
    $average_cost = $_POST['average_cost'];
    $category_id = $_POST['category_id'];
    $image = '';

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Attempt to move the uploaded file to the server
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Update with image
                $sql = "UPDATE destinations SET name=?, description=?, location=?, best_time_to_visit=?, activities=?, accommodations=?, average_cost=?, image=?, category_id=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssdssi", $name, $description, $location, $best_time_to_visit, $activities, $accommodations, $average_cost, $image, $category_id, $id);
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit();
            }
        } else {
            echo "File is not an image.";
            exit();
        }
    } else {
        // Update without image
        $sql = "UPDATE destinations SET name=?, description=?, location=?, best_time_to_visit=?, activities=?, accommodations=?, average_cost=?, category_id=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssdsi", $name, $description, $location, $best_time_to_visit, $activities, $accommodations, $average_cost, $category_id, $id);
    }

    // Execute the query
    if ($stmt->execute()) {
        header('Location: manage_destinations.php');
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch existing destination data
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM destinations WHERE id=$id");
$destination = $result->fetch_assoc();

include('includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-edit"></i> Edit Destination</h2>
        </div>
        <div class="card-body">
            <form action="edit_destination.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $destination['id']; ?>">
                <div class="form-group">
                    <label for="name"><i class="fas fa-map-signs"></i> Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $destination['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="description"><i class="fas fa-align-left"></i> Description</label>
                    <textarea name="description" class="form-control" required><?php echo $destination['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="location"><i class="fas fa-map"></i> Location</label>
                    <input type="text" name="location" class="form-control" value="<?php echo $destination['location']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="best_time_to_visit"><i class="fas fa-calendar-alt"></i> Best Time to Visit</label>
                    <input type="text" name="best_time_to_visit" class="form-control" value="<?php echo $destination['best_time_to_visit']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="activities"><i class="fas fa-futbol"></i> Activities</label>
                    <textarea name="activities" class="form-control" required><?php echo $destination['activities']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="accommodations"><i class="fas fa-bed"></i> Accommodations</label>
                    <textarea name="accommodations" class="form-control" required><?php echo $destination['accommodations']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="average_cost"><i class="fas fa-dollar-sign"></i> Average Cost</label>
                    <input type="number" step="0.01" name="average_cost" class="form-control" value="<?php echo $destination['average_cost']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="image"><i class="fas fa-image"></i> Image</label>
                    <input type="file" name="image" class="form-control-file">
                    <small>Current image: <img src="../assets/images/<?php echo $destination['image']; ?>" alt="<?php echo $destination['name']; ?>" width="100"></small>
                </div>
                <div class="form-group">
                    <label for="category_id"><i class="fas fa-tags"></i> Category</label>
                    <select name="category_id" class="form-control" required>
                        <?php
                        $categories_result = $conn->query("SELECT * FROM destination_categories");
                        while ($category = $categories_result->fetch_assoc()) {
                            $selected = $category['id'] == $destination['category_id'] ? 'selected' : '';
                            echo "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
