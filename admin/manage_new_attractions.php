<?php

include('includes/sidebar.php');
include('../includes/db.php');

// Fetch all new attractions from the database
$sql = "SELECT id, full_name, occupation, identity, attraction_type, description, phone, email, location, media, media_type, status, created_at FROM new_attractions WHERE status='Pending'";
$result = $conn->query($sql);

$attractions = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $attractions[] = $row;
    }
}

// Handle approve action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'approve') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE new_attractions SET status = 'Approved' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: attractions.php");
    exit();
}

// Handle view action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'view') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM new_attractions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $attraction = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Attractions</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <style>
        .btn-action {
            margin: 0 5px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#attractionsTable').DataTable();
        });
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">New Attractions</h2>
        <table id="attractionsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Occupation</th>
                    <th>Identity</th>
                    <th>Attraction Type</th>
                    <th>Description</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($attractions as $attraction) { ?>
                <tr>
                    <td><?php echo $attraction['id']; ?></td>
                    <td><?php echo $attraction['full_name']; ?></td>
                    <td><?php echo $attraction['occupation']; ?></td>
                    <td><?php echo $attraction['identity']; ?></td>
                    <td><?php echo $attraction['attraction_type']; ?></td>
                    <td><?php echo $attraction['description']; ?></td>
                    <td><?php echo $attraction['phone']; ?></td>
                    <td><?php echo $attraction['email']; ?></td>
                    <td>
                        <form action="attractions.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $attraction['id']; ?>">
                            <input type="hidden" name="action" value="view">
                            <button type="submit" class="btn btn-primary btn-action">View</button>
                        </form>
                        <form action="attractions.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $attraction['id']; ?>">
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="btn btn-success btn-action">Approve</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($attraction)) { ?>
    <div class="modal" tabindex="-1" style="display:block; background:rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attraction Details</h5>
                    <button type="button" class="btn-close" onclick="window.location.href='attractions.php';"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Full Name:</strong> <?php echo $attraction['full_name']; ?></p>
                    <p><strong>Occupation:</strong> <?php echo $attraction['occupation']; ?></p>
                    <p><strong>Identity:</strong> <?php echo $attraction['identity']; ?></p>
                    <p><strong>Attraction Type:</strong> <?php echo $attraction['attraction_type']; ?></p>
                    <p><strong>Description:</strong> <?php echo $attraction['description']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $attraction['phone']; ?></p>
                    <p><strong>Email:</strong> <?php echo $attraction['email']; ?></p>
                    <p><strong>Location:</strong> <?php echo $attraction['location']; ?></p>
                    <p><strong>Media:</strong> <?php echo $attraction['media']; ?></p>
                    <p><strong>Media Type:</strong> <?php echo $attraction['media_type']; ?></p>
                    <p><strong>Status:</strong> <?php echo $attraction['status']; ?></p>
                    <p><strong>Created At:</strong> <?php echo $attraction['created_at']; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='attractions.php';">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</body>
</html>
