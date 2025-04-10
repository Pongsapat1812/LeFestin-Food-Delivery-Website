<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User is not logged in.";
    exit();
}

// Check if cart items are provided
if (!isset($_POST['cartItems'])) {
    echo "Cart items are required.";
    exit();
}

$user_id = $_SESSION['user_id'];
$cartItems = json_decode($_POST['cartItems'], true);

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

// Prepare and execute SQL statement to insert checkout items
$stmt = $conn->prepare("INSERT INTO checkout (user_id, item_name, item_price, quantity, total_price) VALUES (?, ?, ?, ?, ?)");
$stmt2 = $conn->prepare("INSERT INTO orders (user_id, total_items, total_price, menu_list, payment_method) VALUES (?, ?, ?, ?, 'Card')");

$total_items = 0;
$total_price = 0;
$menu_list = "";

foreach ($cartItems as $item) {
    $itemName = $item['name'];
    $itemPrice = $item['price'];
    $quantity = $item['quantity'];
    $total_item_price = $itemPrice * $quantity;
    $total_price += $total_item_price;
    $total_items += $quantity;
    $menu_list .= $quantity . " x " . $itemName . ", ";
    $stmt->bind_param("isdid", $user_id, $itemName, $itemPrice, $quantity, $total_item_price);
    $stmt->execute();
}

$stmt2->bind_param("iids", $user_id, $total_items, $total_price, $menu_list);
$stmt2->execute();

$stmt->close();
$stmt2->close();
$conn->close();

echo "Checkout items saved successfully.";
?>
