<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM tickets ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("No records found in the database."); // DEBUG: See if this message appears
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tickets</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h2>Booked Tickets</h2>

<table>
    <tr>
        <th>ID</th><th>Name</th><th>Mobile No</th><th>Email</th>
        <th>From</th><th>To</th><th>Date</th><th>Time</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['mobile_no']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['from_location']; ?></td>
        <td><?php echo $row['to_location']; ?></td>
        <td><?php echo $row['travel_date']; ?></td>
        <td><?php echo $row['travel_time']; ?></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
