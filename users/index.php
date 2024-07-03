<?php
include 'includes/session.php';
include('header.php'); ?>
<div class="container mt-4">
    <h1>Welcome to the Tourism Portal</h1>
    <p>Explore the world with our exciting tours and destinations.</p>

    <form class="form-inline my-2 my-lg-0" method="GET" action="index.php">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search Destinations" aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>

    <div class="row mt-4">
        <?php
        include('../includes/db.php');
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT * FROM destinations WHERE name LIKE ?";
        $stmt = $conn->prepare($query);
        $search_param = "%" . $search . "%";
        $stmt->bind_param("s", $search_param);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='card'>";
                echo "<img src='../assets/images/" . $row['image'] . "' class='card-img-top' alt='" . $row['name'] . "'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . $row['name'] . "</h5>";
                echo "<p class='card-text'>" . substr($row['description'], 0, 100) . "...</p>";
                echo "<a href='destination_details.php?id=" . $row['id'] . "' class='btn btn-primary'>Learn More</a>";
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
