<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";  // Change if needed
$password = "";  // Change if needed
$dbname = "bus_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]));
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $mobile_no = $_POST['mobile_no'] ?? '';
    $email = $_POST['email'] ?? '';
    $from_location = $_POST['from'] ?? '';
    $to_location = $_POST['to'] ?? '';
    $travel_date = $_POST['date'] ?? '';
    $travel_time = $_POST['time'] ?? '';

    // Validate required fields
    if (empty($name) || empty($email) || empty($from_location) || empty($to_location) || empty($travel_date) || empty($travel_time)) {
        echo json_encode(["success" => false, "message" => "All fields are required!"]);
        exit;
    }

    // Insert booking into the database
    $stmt = $conn->prepare("INSERT INTO tickets (name, mobile_no, email, from_location, to_location, travel_date, travel_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $mobile_no, $email, $from_location, $to_location, $travel_date, $travel_time);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error booking ticket: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method!"]);
}
?>
