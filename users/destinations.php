<?php 
include 'includes/session.php';
include('header.php'); ?>
<?php include('../includes/db.php'); ?>

<div class="container mt-4">
    <h1>Available Attractions</h1>
    <div class="row mt-4">
        <?php
        $query = "SELECT * FROM destinations";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='card'>";
                echo "<img src='../assets/images/" . $row['image'] . "' class='card-img-top' alt='" . $row['name'] . "'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row['name'] . "</h5>";
                echo "<p class='card-text'>" . substr($row['description'], 0, 100) . "...</p>";
                echo "<a href='destination_details.php?id=" . $row['id'] . "' class='btn btn-primary'>Learn More</a>";
                echo "<a href='booking_form.php?destination_id=" . $row['id'] . "' class='btn btn-success mt-2'>Book Now</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='col-12'><p>No destinations found.</p></div>";
        }
        ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
