<?php
session_start();

if (isset($_SESSION['role'])) {
    echo $_SESSION['role'];
} else {
    echo "not_logged_in";
}
?>
