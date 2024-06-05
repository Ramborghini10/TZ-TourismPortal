<?php
include('../includes/session.php');

// Include your database connection file
include('../includes/db.php');

// Function to get total number of users
function getTotalUsers() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total_users FROM users";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total_users'];
}

// Function to get total number of destinations
function getTotalDestinations() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total_destinations FROM destinations";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total_destinations'];
}

// Function to get total number of bookings
function getTotalBookings() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total_bookings FROM bookings";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total_bookings'];
}

// Function to get monthly bookings data
function getMonthlyBookingsData() {
    global $conn;
    $sql = "SELECT MONTH(booking_date) AS month, COUNT(*) AS total_bookings FROM bookings GROUP BY MONTH(booking_date)";
    $result = $conn->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[$row['month']] = $row['total_bookings'];
    }
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .card-body {
            background-color: #f8f9fa;
        }
        .card-body h5 {
            margin-bottom: 20px;
        }
        .card-body ul li {
            list-style-type: none;
            margin-bottom: 10px;
        }
        .icon {
            font-size: 24px;
            margin-right: 10px;
        }
        canvas {
            max-width: 100%;
        }
    </style>
</head>
<body>
<?php
include('includes/header.php');
include('includes/sidebar.php');
?>

<!-- Main Content -->
<div class="container mt-5">
    <h1>Welcome, <?php echo $_SESSION['email']; ?></h1>

    <div class="card">
        <div class="card-header">
            <h3>Statistics</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body bg-success">
                            <h5 class="card-title"><i class="fas fa-users icon"></i> Total Users</h5>
                            <p class="card-text"><?php echo getTotalUsers(); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body bg-secondary">
                            <h5 class="card-title"><i class="fas fa-map-marker-alt icon"></i> Total Destinations</h5>
                            <p class="card-text"><?php echo getTotalDestinations(); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body bg-warning">
                            <h5 class="card-title"><i class="fas fa-book icon"></i> Total Bookings</h5>
                            <p class="card-text"><?php echo getTotalBookings(); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body bg-warning">
                            <h5 class="card-title"><i class="fas fa-book icon"></i> Total Bookings</h5>
                            <p class="card-text"><?php echo getTotalBookings(); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5 pb-5">
        <div class="card-header">
            <h3>Monthly Bookings</h3>
        </div>
        <div class="card-body p-5 mb-5">
            <canvas id="bookingsChart"></canvas>
        </div>
    </div>
</div>

<script>
    // Get the canvas element
    const bookingsCanvas = document.getElementById('bookingsChart');
    const ctx = bookingsCanvas.getContext('2d');

    // Get monthly bookings data
    const monthlyBookingsData = <?php echo json_encode(getMonthlyBookingsData()); ?>;

    // Chart configuration
    const chartConfig = {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Monthly Bookings',
                data: Object.values(monthlyBookingsData),
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
    };

    // Create the chart
    const bookingsChart = new Chart(ctx, chartConfig);
</script>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
