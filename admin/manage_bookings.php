<?php 
include('../includes/session.php');
include('includes/sidebar.php');
?>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Manage Bookings</h2>
            <a href="create_booking.php" class="btn btn-success mb-2"><i class="fas fa-plus"></i> Add New Booking</a>
        </div>
        <div class="card-body">
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-info">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>
            <table id="bookingsTable" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Tour</th>
                        <th>Booking Date</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../includes/db.php');
                    $query = "SELECT bookings.*, users.first_name, users.last_name, tours.name AS tour_name 
                              FROM bookings 
                              LEFT JOIN users ON bookings.user_id = users.id
                              LEFT JOIN tours ON bookings.tour_id = tours.id";
                    $result = $conn->query($query);
                    
                    if (!$result) {
                        die("Query Failed: " . $conn->error);
                    }

                    $serial_number = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $serial_number++ . "</td>";
                        echo "<td>" . $row['first_name'] . "</td>";
                        echo "<td>" . $row['last_name'] . "</td>";
                        echo "<td>" . $row['tour_name'] . "</td>";
                        echo "<td>" . $row['booking_date'] . "</td>";
                        echo "<td>" . ucfirst($row['status']) . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td>
                            <a href='edit_booking.php?id=" . $row['id'] . "' class='btn btn-warning'><i class='fas fa-edit'></i></a>
                            <a href='delete_booking.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this booking?\");'><i class='fas fa-trash'></i></a>
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
        $('#bookingsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            columnDefs: [
                { orderable: false, targets: 7 }
            ],
            autoWidth: false,
            responsive: true
        });
    });
</script>
