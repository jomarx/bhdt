<?php 
date_default_timezone_set("Asia/Manila");
error_reporting(0);
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bhdt";
// Create connection



$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
