<?php
// include('../includes/session.php');
include('includes/header.php');
include('includes/db.php');

// Fetch all categories
$categoriesResult = $conn->query("SELECT * FROM destination_categories");

?>

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Available attractions</h2>
            <!-- <a href="create_destination.php" class="btn btn-success mb-2"><i class="fas fa-plus"></i> Add New Destination</a> -->
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                <?php
                $firstCategory = true;
                while ($category = $categoriesResult->fetch_assoc()) {
                    $categoryId = $category['id'];
                    $categoryName = $category['name'];
                    $activeClass = $firstCategory ? 'active' : '';
                    echo "<li class='nav-item'>";
                    echo "<a class='nav-link {$activeClass}' id='category-tab-{$categoryId}' data-toggle='tab' href='#category-{$categoryId}' role='tab' aria-controls='category-{$categoryId}' aria-selected='true'>{$categoryName}</a>";
                    echo "</li>";
                    $firstCategory = false;
                }
                ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content mt-3" id="categoryTabsContent">
                <?php
                // Reset pointer to fetch categories again
                $categoriesResult->data_seek(0);

                $firstCategory = true;
                while ($category = $categoriesResult->fetch_assoc()) {
                    $categoryId = $category['id'];
                    $activeClass = $firstCategory ? 'show active' : '';
                    echo "<div class='tab-pane fade {$activeClass}' id='category-{$categoryId}' role='tabpanel' aria-labelledby='category-tab-{$categoryId}'>";

                    // Fetch destinations for current category
                    $query = "SELECT * FROM destinations WHERE category_id = {$categoryId}";
                    $destinationsResult = $conn->query($query);

                    // Display destinations as cards
                    echo "<div class='row row-cols-1 row-cols-md-4 g-4'>";
                    while ($row = $destinationsResult->fetch_assoc()) {
                        echo "<div class='col mb-4'>";
                        echo "<div class='card h-100'>";
                        echo "<img src='assets/images/{$row['image']}' class='card-img-top' alt='{$row['name']}'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>{$row['name']}</h5>";
                        echo "<p class='card-text'>{$row['description']}</p>";
                        echo "<a href='destination_details.php?id={$row['id']}' class='btn btn-info'><i class='fas fa-info-circle'></i> Read More</a>";

                        // Check if logged in for booking link

                        echo "<a href='book_form.php?id={$row['id']}' class='btn btn-primary mx-2'><i class='fas fa-book'></i> Book</a>";


                        echo "</div>"; // card-body
                        echo "</div>"; // card
                        echo "</div>"; // col
                    }
                    echo "</div>"; // row

                    echo "</div>"; // tab-pane
                    $firstCategory = false;
                }
                ?>
            </div> <!-- categoryTabsContent -->
        </div> <!-- card-body -->
    </div> <!-- card -->
</div> <!-- container-fluid -->

<?php include('includes/footer.php'); ?>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

