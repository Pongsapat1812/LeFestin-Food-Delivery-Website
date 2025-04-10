<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Check if payment details are provided
if (!isset($_POST['cardholderName']) || !isset($_POST['cardNumber']) || !isset($_POST['expiryDate']) || !isset($_POST['cvv'])) {
    echo "Payment details are required.";
    exit();
}

$cardholderName = $_POST['cardholderName'];
$cardNumber = $_POST['cardNumber'];
$expiryDate = $_POST['expiryDate'];
$cvv = $_POST['cvv'];
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

// Prepare and execute SQL statement to insert payment details
$stmt = $conn->prepare("INSERT INTO payment_detail (user_id, cardholderName, cardNumber, expiryDate, cvv) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $user_id, $cardholderName, $cardNumber, $expiryDate, $cvv);

if ($stmt->execute()) {
    echo "Payment details saved successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
