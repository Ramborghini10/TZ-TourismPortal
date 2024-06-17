<?php
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO destination_categories (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $description);
    $stmt->execute();

    header('Location: manage_categories.php');
}

include('includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-plus"></i> Add New Category</h2>
        </div>
        <div class="card-body">
            <form action="create_category.php" method="POST">
                <div class="form-group">
                    <label for="name"><i class="fas fa-tag"></i> Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description"><i class="fas fa-align-left"></i> Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Add Category</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
