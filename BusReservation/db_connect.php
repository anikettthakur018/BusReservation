<?php
$servername = "localhost";
$username = "root"; // Change if using another username
$password = ""; // Set your MySQL password
$database = "bus_reservation";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
