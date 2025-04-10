<?php
$servername = "10.1.3.40";
$username_db = "65102010690";
$password_db = "65102010690";
$dbname = "65102010690";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set MySQL server's timezone to GMT+7 for the current session
$conn->query("SET time_zone = '+07:00'");

// Reset AUTO_INCREMENT value to 1
$conn->query("ALTER TABLE users AUTO_INCREMENT = 1");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Storing password as MD5 hash
    
    // Check if the user is an admin or a regular user
    $role = isset($_POST['role']) ? $_POST['role'] : 'user';

    // Insert the new user
    $sql = "INSERT INTO users (firstname, lastname, dob, phone, email, password, role) 
            VALUES ('$firstname', '$lastname', '$dob', '$phone', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to index.php after successful registration
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
