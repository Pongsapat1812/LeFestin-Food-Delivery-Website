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

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'restaurant') {
    header("Location: ../index.php");
    exit();
}

// Mark order as completed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];
        $sql_update_order = "UPDATE orders SET completed = 1 WHERE id = $order_id";
        $conn->query($sql_update_order);
    } elseif (isset($_POST['preparing_order_id'])) {
        $order_id = $_POST['preparing_order_id'];
        $sql_update_order = "UPDATE orders SET preparing = 1 WHERE id = $order_id";
        $conn->query($sql_update_order);
    }
}

// Fetch restaurant's orders with user information
$sql_orders = "SELECT orders.*, users.firstname, users.lastname 
                FROM orders 
                JOIN users ON orders.user_id = users.id 
                WHERE orders.completed = 0 
                ORDER BY orders.created_at ASC";

$result_orders = $conn->query($sql_orders);

$orders = [];
if ($result_orders->num_rows > 0) {
    while ($row = $result_orders->fetch_assoc()) {
        // Split the menu list by comma and display each item on a new line
        $menu_items = explode(',', $row['menu_list']);
        $menu_list = '';
        foreach ($menu_items as $item) {
            $menu_list .= trim($item) . "<br>";
        }
        $row['menu_list'] = $menu_list;
        $orders[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Panel</title>
    <!-- Bootstrap CSS from CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Restaurant Panel</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Orders</h2>
        <div class="table-responsive">
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Menu List</th>
                        <th>Total Items</th>
                        <th>Total Price</th>
                        <th>Payment Method</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) : ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['firstname'].' '.$order['lastname']; ?></td>
                            <td><?php echo $order['menu_list']; ?></td>
                            <td><?php echo $order['total_items']; ?></td>
                            <td><?php echo $order['total_price']; ?></td>
                            <td><?php echo $order['payment_method']; ?></td>
                            <td><?php echo $order['created_at']; ?></td>
                            <td>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="preparing_order_id" value="<?php echo $order['id']; ?>">
                                    <button type="submit" class="btn btn-warning">Preparing</button>
                                </form>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <button type="submit" class="btn btn-success">Completed</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
</body>

</html>
