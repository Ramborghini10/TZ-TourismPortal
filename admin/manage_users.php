<?php 
include('includes/sidebar.php');
?>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Manage Users</h2>
            <a href="create_user.php" class="btn btn-success mb-2"><i class="fas fa-plus"></i> Add New User</a>
        </div>
        <div class="card-body">
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-info">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>
            <table id="usersTable" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Serial No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Country</th>
                        <th>IP Address</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../includes/db.php');
                    $query = "SELECT * FROM users";
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
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . ucfirst($row['role']) . "</td>";
                        echo "<td>" . $row['country'] . "</td>";
                        echo "<td>" . $row['ip_address'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td>
                            <a href='edit_user.php?id=" . $row['id'] . "' class='btn btn-warning'><i class='fas fa-edit'></i></a>
                            <a href='delete_user.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\");'><i class='fas fa-trash'></i></a>
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
        $('#usersTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            columnDefs: [
                { orderable: false, targets: 9 }
            ],
            autoWidth: false,
            responsive: true
        });
    });
</script>
