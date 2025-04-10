<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Check if latitude and longitude are provided
if (!isset($_POST['latitude']) || !isset($_POST['longitude'])) {
    echo "Latitude and longitude are required.";
    exit();
}

$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$user_id = $_SESSION['user_id'];

// Database connection
$servername = "10.1.3.40";
$username = "65102010690";
$password = "65102010690";
$dbname = "65102010690";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute SQL statement to insert location
$stmt = $conn->prepare("INSERT INTO locations (user_id, latitude, longitude) VALUES (?, ?, ?)");
$stmt->bind_param("idd", $user_id, $latitude, $longitude);

if ($stmt->execute()) {
    echo "Location saved successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
