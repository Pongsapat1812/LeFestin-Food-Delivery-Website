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

    $id = $_POST['editUserId'];
    $firstname = $_POST['editFirstname'];
    $lastname = $_POST['editLastname'];
    $dob = $_POST['editDob'];
    $phone = $_POST['editPhone'];
    $email = $_POST['editEmail'];
    $password = $_POST['editPassword'];
    $role = $_POST['editRole'];

    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', dob='$dob', phone='$phone', email='$email', password='$password', role='$role' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_panel.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
