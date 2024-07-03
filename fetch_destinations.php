<?php
// fetch_destinations.php

include('includes/db.php');
session_start(); // Start session to check user login status

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0; // Default to 0 for all categories

// Adjust your SQL query to fetch destinations based on category_id
if ($category_id == 0) {
    // Fetch all destinations
    $query = "SELECT destinations.*, destination_categories.name AS category_name 
              FROM destinations 
              LEFT JOIN destination_categories ON destinations.category_id = destination_categories.id";
} else {
    // Fetch destinations for a specific category
    $query = "SELECT destinations.*, destination_categories.name AS category_name 
              FROM destinations 
              LEFT JOIN destination_categories ON destinations.category_id = destination_categories.id
              WHERE destinations.category_id = $category_id";
}

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='col'>";
        echo "<div class='card'>";
        echo "<img src='../assets/images/" . $row['image'] . "' class='card-img-top' alt='" . $row['name'] . "'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $row['name'] . "</h5>";
        echo "<p class='card-text'>" . $row['description'] . "</p>";
        // Check if user is logged in for booking button
        if (isset($_SESSION['user_id'])) {
            echo "<a href='book_destination.php?id=" . $row['id'] . "' class='btn btn-primary'><i class='fas fa-book'></i> Book</a>";
        } else {
            echo "<button class='btn btn-primary' onclick='redirectToLogin()'><i class='fas fa-book'></i> Book</button>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No destinations found.</p>";
}

$conn->close();

// Function to redirect to login page
function redirectToLogin() {
    echo "<script>window.location.href = '../login.php';</script>";
}
?>
