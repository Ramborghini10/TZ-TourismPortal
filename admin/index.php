<?php
include('../includes/session.php');
include('../includes/db.php'); // Include your database connection file

include('includes/sidebar.php');

// Initialize variables to store statistical data
$totalDestinations = 0;
$totalTours = 0;
$totalBookings = 0;
$totalUsers = 0;
$bookingData = [];
$destinationData = [];

// Query to fetch total number of destinations
$sqlDestinations = "SELECT COUNT(*) AS total_destinations FROM destinations";
$resultDestinations = mysqli_query($conn, $sqlDestinations);
if ($resultDestinations) {
    $rowDestinations = mysqli_fetch_assoc($resultDestinations);
    $totalDestinations = $rowDestinations['total_destinations'];
}

// Query to fetch total number of tours
$sqlTours = "SELECT COUNT(*) AS total_tours FROM tours";
$resultTours = mysqli_query($conn, $sqlTours);
if ($resultTours) {
    $rowTours = mysqli_fetch_assoc($resultTours);
    $totalTours = $rowTours['total_tours'];
}

// Query to fetch total number of bookings
$sqlBookings = "SELECT COUNT(*) AS total_bookings FROM bookings";
$resultBookings = mysqli_query($conn, $sqlBookings);
if ($resultBookings) {
    $rowBookings = mysqli_fetch_assoc($resultBookings);
    $totalBookings = $rowBookings['total_bookings'];
}

// Query to fetch total number of users
$sqlUsers = "SELECT COUNT(*) AS total_users FROM users";
$resultUsers = mysqli_query($conn, $sqlUsers);
if ($resultUsers) {
    $rowUsers = mysqli_fetch_assoc($resultUsers);
    $totalUsers = $rowUsers['total_users'];
}

// Fetch booking data for monthly bookings chart
$sqlMonthlyBookings = "SELECT MONTH(booking_date) AS month, COUNT(*) AS bookings 
                       FROM bookings 
                       GROUP BY MONTH(booking_date)";
$resultMonthlyBookings = mysqli_query($conn, $sqlMonthlyBookings);
while ($row = mysqli_fetch_assoc($resultMonthlyBookings)) {
    $bookingData[] = ['month' => $row['month'], 'bookings' => $row['bookings']];
}

// Fetch destination data for top destinations pie chart
$sqlTopDestinations = "SELECT tours.name AS name, COUNT(bookings.id) AS count
                       FROM bookings
                       JOIN tours ON bookings.tour_id = tours.id
                       GROUP BY tours.name
                       ORDER BY count DESC
                       LIMIT 5";
$resultTopDestinations = mysqli_query($conn, $sqlTopDestinations);
while ($row = mysqli_fetch_assoc($resultTopDestinations)) {
    $destinationData[] = ['name' => $row['name'], 'count' => $row['count']];
}

?>

<div class="container">
    <h2>Admin Dashboard</h2>
    
    <!-- Statistics Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Destinations</h5>
                    <p class="card-text"><?php echo $totalDestinations; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Tours</h5>
                    <p class="card-text"><?php echo $totalTours; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Bookings</h5>
                    <p class="card-text"><?php echo $totalBookings; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text"><?php echo $totalUsers; ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Monthly Bookings Chart</h5>
                    <canvas id="monthlyBookingsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Destinations Chart</h5>
                    <canvas id="topDestinationsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<!-- Chart.js CDN for charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Monthly Bookings Chart Data
    var bookingData = <?php echo json_encode($bookingData); ?>;
    var months = bookingData.map(function(item) { return item.month; });
    var bookings = bookingData.map(function(item) { return item.bookings; });

    var ctx1 = document.getElementById('monthlyBookingsChart').getContext('2d');
    var monthlyBookingsChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Monthly Bookings',
                data: bookings,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Top Destinations Chart Data
    var destinationData = <?php echo json_encode($destinationData); ?>;
    var destinationNames = destinationData.map(function(item) { return item.name; });
    var destinationCounts = destinationData.map(function(item) { return item.count; });

    var ctx2 = document.getElementById('topDestinationsChart').getContext('2d');
    var topDestinationsChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: destinationNames,
            datasets: [{
                label: 'Top Destinations',
                data: destinationCounts,
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff']
            }]
        }
    });
</script>
