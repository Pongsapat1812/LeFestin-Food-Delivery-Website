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

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=users.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, array_keys($users[0])); // header

    foreach ($users as $user) {
        fputcsv($output, $user);
    }
    fclose($output);
}

$conn->close();
?>
