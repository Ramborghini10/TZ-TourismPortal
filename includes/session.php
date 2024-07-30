<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    header("location: ../index.php");
    exit;
}
