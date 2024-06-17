<?php 
include('includes/sidebar.php');
?>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Manage Tours</h2>
            <a href="create_tour.php" class="btn btn-success mb-2"><i class="fas fa-plus"></i> Add New Tour</a>
        </div>
        <div class="card-body">
            <table id="toursTable" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>Destination</th>
                        <th>Name</th>
                        <th>Itinerary</th>
                        <th>Price</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../includes/db.php');
                    $result = $conn->query("SELECT tours.*, destinations.name AS destination_name FROM tours 
                                            LEFT JOIN destinations ON tours.destination_id = destinations.id");
                    $serial_number = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $serial_number++ . "</td>";
                        echo "<td>" . $row['destination_name'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['itinerary'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td>
                            <a href='edit_tour.php?id=" . $row['id'] . "' class='btn btn-warning'><i class='fas fa-edit'></i></a>
                            <a href='delete_tour.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this tour?\");'><i class='fas fa-trash'></i></a>
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
        $('#toursTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            columnDefs: [
                { orderable: false, targets: 6 }
            ],
            autoWidth: false,
            responsive: true
        });
    });
</script>
