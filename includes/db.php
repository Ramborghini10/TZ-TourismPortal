<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$host = 'localhost';
$db = 'tourism_portal';
$user = 'root';
$pass = 'passw0rd';

$conn = mysqli_connect($host,$user,$pass,$db);

if(!$conn){
    die('Database connection error');
}