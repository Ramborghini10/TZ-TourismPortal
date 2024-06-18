<?php include('includes/header.php'); ?>

<div class="container mt-4">
    <h1>Available Tours</h1>

    <form class="form-inline my-2 my-lg-0" method="GET" action="tours.php">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search Tours" aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>

    <div class="row mt-4">
        <?php
        include('includes/db.php');
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT tours.*, destinations.name AS destination_name FROM tours LEFT JOIN destinations ON tours.destination_id = destinations.id WHERE tours.name LIKE ?";
        $stmt = $conn->prepare($query);
        $search_param = "%" . $search . "%";
        $stmt->bind_param("s", $search_param);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='card'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row['name'] . "</h5>";
                echo "<p class='card-text'>" . substr($row['itinerary'], 0, 100) . "...</p>";
                echo "<p><strong>Destination:</strong> " . $row['destination_name'] . "</p>";
                echo "<p><strong>Price:</strong> $" . number_format($row['price'], 2) . "</p>";
                echo "<a href='tour_details.php?id=" . $row['id'] . "' class='btn btn-primary'>Learn More</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='col-12'><p>No tours found.</p></div>";
        }
        ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
