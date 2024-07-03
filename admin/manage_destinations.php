<?php 
include('../includes/session.php');
include('includes/sidebar.php');
?>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Manage Destinations</h2>
            <a href="create_destination.php" class="btn btn-success mb-2"><i class="fas fa-plus"></i> Add New Destination</a>
        </div>
        <div class="card-body">
            <table id="destinationsTable" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Best Time to Visit</th>
                        <th>Activities</th>
                        <th>Accommodations</th>
                        <th>Average Cost</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../includes/db.php');
                    $result = $conn->query("SELECT destinations.*, destination_categories.name AS category_name FROM destinations 
                                            LEFT JOIN destination_categories ON destinations.category_id = destination_categories.id");
                    $serial_number = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $serial_number++ . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['category_name'] . "</td>";
                        echo "<td>" . $row['location'] . "</td>";
                        echo "<td>" . $row['best_time_to_visit'] . "</td>";
                        echo "<td>" . $row['activities'] . "</td>";
                        echo "<td>" . $row['accommodations'] . "</td>";
                        echo "<td>" . $row['average_cost'] . "</td>";
                        echo "<td><img src='../assets/images/" . $row['image'] . "' alt='" . $row['name'] . "' width='100'></td>";
                        echo "<td>
                            <a href='edit_destination.php?id=" . $row['id'] . "' class='btn btn-warning'><i class='fas fa-edit'></i></a>
                            <a href='delete_destination.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this destination?\");'><i class='fas fa-trash'></i></a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<!-- DataTables and Buttons Extension -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#destinationsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            columnDefs: [
                { orderable: false, targets: 10 }
            ],
            autoWidth: false,
            responsive: true
        });
    });
</script>
