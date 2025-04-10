<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$servername = "10.1.3.40";
$username = "65102010690";
$password = "65102010690";
$database = "65102010690";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = md5($_POST['password']);
$role = $_POST['role'];

// Fetch the maximum ID from the users table
$sql_max_id = "SELECT MAX(id) AS max_id FROM users";
$result_max_id = $conn->query($sql_max_id);
$max_id_row = $result_max_id->fetch_assoc();
$max_id = $max_id_row['max_id'] + 1;

// Insert the user with the incremented ID
$sql = "INSERT INTO users (id, firstname, lastname, dob, phone, email, password, role) 
        VALUES ('$max_id', '$firstname', '$lastname', '$dob', '$phone', '$email', '$password', '$role')";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_panel.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
