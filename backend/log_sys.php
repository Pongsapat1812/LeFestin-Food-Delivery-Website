<?php
session_start();

$servername = "10.1.3.40";
$username_db = "65102010690";
$password_db = "65102010690";
$dbname = "65102010690";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Using MD5 hashing

    // Check in the team table for admin, owner, and restaurant login
    $sql_team = "SELECT * FROM team WHERE email='$email'";
    $result_team = $conn->query($sql_team);

    if ($result_team->num_rows > 0) {
        $row_team = $result_team->fetch_assoc();
        $db_password = $row_team['password'];
        $role = $row_team['role'];
        
        // Verify password
        if ($password == $db_password) {
            $_SESSION['user_id'] = $row_team['team_id'];
            $_SESSION['email'] = $row_team['email'];
            $_SESSION['role'] = $role;
            // Insert login log
            $login_status = "successful";
            $insert_log = "INSERT INTO login_attempts (email, login_status) VALUES ('$email', '$login_status')";
            $conn->query($insert_log);

            if ($role == 'admin') {
                header("Location: admin_panel.php");
            } elseif ($role == 'owner') {
                header("Location: owner.php");
            } elseif ($role == 'restaurant') {
                header("Location: rest.php");
            }
            $_SESSION['show_door_button'] = true; // Set session variable to true
            exit();
        } else {
            // Insert failed login log
            $login_status = "unsuccessful";
            $insert_log = "INSERT INTO login_attempts (email, login_status) VALUES ('$email', '$login_status')";
            $conn->query($insert_log);
            header("Location: ../index.php?error=notfound");
            exit();
        }
    } else {
        // Check in the users table for regular user login
        $sql_user = "SELECT * FROM users WHERE email='$email'";
        $result_user = $conn->query($sql_user);

        if ($result_user->num_rows > 0) {
            $row_user = $result_user->fetch_assoc();
            $db_password = $row_user['password'];
            // Verify password
            if ($password == $db_password) {
                $_SESSION['user_id'] = $row_user['id'];
                $_SESSION['firstname'] = $row_user['firstname'];
                $_SESSION['lastname'] = $row_user['lastname'];
                $_SESSION['email'] = $row_user['email'];
                $_SESSION['role'] = $row_user['role'];
                // Insert login log
                $login_status = "successful";
                $insert_log = "INSERT INTO login_attempts (email, login_status) VALUES ('$email', '$login_status')";
                $conn->query($insert_log);
                header("Location: ../index.php");
                exit();
            } else {
                // Insert failed login log
                $login_status = "unsuccessful";
                $insert_log = "INSERT INTO login_attempts (email, login_status) VALUES ('$email', '$login_status')";
                $conn->query($insert_log);
                header("Location: ../index.php?error=notfound");
                exit();
            }
        } else {
            // Insert failed login log
            $login_status = "unsuccessful";
            $insert_log = "INSERT INTO login_attempts (email, login_status) VALUES ('$email', '$login_status')";
            $conn->query($insert_log);
            header("Location: ../index.php?error=notfound");
            exit();
        }
    }
}

$conn->close();
?>
