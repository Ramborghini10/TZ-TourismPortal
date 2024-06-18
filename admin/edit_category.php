<?php
include('../includes/session.php');
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "UPDATE destination_categories SET name=?, description=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $description, $id);
    $stmt->execute();

    header('Location: manage_categories.php');
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM destination_categories WHERE id=$id");
$category = $result->fetch_assoc();

include('includes/sidebar.php');
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-edit"></i> Edit Category</h2>
        </div>
        <div class="card-body">
            <form action="edit_category.php?id=<?php echo $id; ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                <div class="form-group">
                    <label for="name"><i class="fas fa-tag"></i> Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $category['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="description"><i class="fas fa-align-left"></i> Description</label>
                    <textarea name="description" class="form-control"><?php echo $category['description']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
