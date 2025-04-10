<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $id = $_POST['editTeamId'];
    $email = $_POST['editTeamEmail'];
    $password = $_POST['editTeamPassword'];
    $role = $_POST['editTeamRole'];

    $sql = "UPDATE team SET email='$email', password='$password', role='$role' WHERE team_id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_panel.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
