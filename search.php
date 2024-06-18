<?php
include('includes/db.php');

$query = isset($_GET['query']) ? $_GET['query'] : '';

$searchQuery = "SELECT name, description, image FROM destinations WHERE name LIKE ?";
$stmt = $conn->prepare($searchQuery);
$searchTerm = '%' . $query . '%';
$stmt->bind_param('s', $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$attractions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $attractions[] = $row;
    }
}

if (empty($attractions)) {
    echo '<div class="carousel-item active">
            <div class="d-flex justify-content-center">
                <div class="card" style="width: 45%;">
                    <img src="assets/images/no_image_available.png" class="card-img-top" alt="No attractions available">
                    <div class="card-body">
                        <h5 class="card-title">No attractions available</h5>
                        <p class="card-text">Please check back later</p>
                    </div>
                </div>
            </div>
          </div>';
} else {
    foreach (array_chunk($attractions, 2) as $index => $attractionChunk) {
        echo '<div class="carousel-item '. ($index === 0 ? 'active' : '') .'">
                <div class="d-flex justify-content-center">';
        foreach ($attractionChunk as $attraction) {
            echo '<div class="card" style="width: 45%;" onclick="location.href=\'destination.php?name='. urlencode($attraction['name']) .'\'>
                    <img src="assets/images/'. htmlspecialchars($attraction['image']) .'" class="card-img-top" alt="'. htmlspecialchars($attraction['name']) .'">
                    <div class="card-body">
                        <h5 class="card-title">'. htmlspecialchars($attraction['name']) .'</h5>
                        <p class="card-text">'. htmlspecialchars($attraction['description']) .'</p>
                    </div>
                  </div>';
        }
        echo '</div>
              </div>';
    }
}
?>
