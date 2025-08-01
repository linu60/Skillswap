<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default for XAMPP
$database = "skillswap"; // Make sure this is your DB name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

