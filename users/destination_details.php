<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include 'includes/session.php';
include('header.php'); 
?>

<div class="container mt-4">
    <?php
    include('includes/db.php');
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $query = "SELECT * FROM destinations WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $destination = $result->fetch_assoc();
        echo "<h1>" . $destination['name'] . "</h1>";
        echo "<img src='assets/images/" . $destination['image'] . "' class='img-fluid' alt='" . $destination['name'] . "'>";
        echo "<p>" . $destination['description'] . "</p>";
        echo "<p><strong>Location:</strong> " . $destination['location'] . "</p>";
        echo "<p><strong>Best Time to Visit:</strong> " . $destination['best_time_to_visit'] . "</p>";
        echo "<p><strong>Activities:</strong> " . $destination['activities'] . "</p>";
        echo "<p><strong>Accommodations:</strong> " . $destination['accommodations'] . "</p>";
        echo "<p><strong>Average Cost:</strong> $" . number_format($destination['average_cost'], 2) . "</p>";

        // Fetch related destinations by category
        $category_id = $destination['category_id'];
        $related_query = "SELECT * FROM destinations WHERE category_id=? AND id!=? LIMIT 4";
        $related_stmt = $conn->prepare($related_query);
        $related_stmt->bind_param("ii", $category_id, $id);
        $related_stmt->execute();
        $related_result = $related_stmt->get_result();

        if ($related_result->num_rows > 0) {
            echo "<h3>Related Destinations</h3>";
            echo "<div class='row'>";
            while ($related = $related_result->fetch_assoc()) {
                echo "<div class='col-md-3 mb-4'>";
                echo "<div class='card'>";
                echo "<img src='assets/images/" . $related['image'] . "' class='card-img-top' alt='" . $related['name'] . "'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $related['name'] . "</h5>";
                echo "<a href='destination_details.php?id=" . $related['id'] . "' class='btn btn-primary'>Learn More</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No related destinations found.</p>";
        }
    } else {
        echo "<p>Destination not found.</p>";
    }
    ?>
</div>

<?php include('../includes/footer.php'); ?>
