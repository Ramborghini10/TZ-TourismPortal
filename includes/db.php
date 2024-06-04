<?php

$host = 'localhost';
$db = 'tourism_portal';
$user = 'root';
$pass = 'passw0rd';

$conn = mysqli_connect($host,$user,$pass,$db);

if(!$conn){
    die('Database connection error');
}else{
    echo 'Database connected';
}   