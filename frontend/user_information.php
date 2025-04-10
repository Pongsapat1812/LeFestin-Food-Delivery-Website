<?php
session_start();
$servername = "10.1.3.40";
$username_db = "65102010690";
$password_db = "65102010690";
$dbname = "65102010690";
$conn = new mysqli($servername, $username_db, $password_db, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT * FROM users WHERE id = $user_id";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $firstname = $row_user['firstname'];
    $lastname = $row_user['lastname'];
    $dob = $row_user['dob'];
    $phone = $row_user['phone'];
    $email = $row_user['email'];
}

// Fetch payment details
$sql_payment = "SELECT * FROM payment_detail WHERE user_id = $user_id";
$result_payment = $conn->query($sql_payment);
$payment_row = $result_payment->fetch_assoc();
$cardholderName = $payment_row['cardholderName'];
$cardNumber = $payment_row['cardNumber'];
$expiryDate = $payment_row['expiryDate'];
$cvv = $payment_row['cvv'];

// Fetch address details
$sql_address = "SELECT * FROM locations WHERE user_id = $user_id";
$result_address = $conn->query($sql_address);
$address_row = $result_address->fetch_assoc();
$latitude = $address_row['latitude'];
$longitude = $address_row['longitude'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_address'])) {
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        $sql_update_address = "UPDATE locations SET latitude='$latitude', longitude='$longitude' WHERE user_id=$user_id";
        if ($conn->query($sql_update_address) === TRUE) {
            header("Location: user_information.php");
            exit();
        } else {
            echo "Error updating address: " . $conn->error;
        }
    }
}

// Fetch order history
$sql_orders = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id ASC";
$result_orders = $conn->query($sql_orders);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_info'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $dob = $_POST['dob'];
        $phone = $_POST['phone'];

        $sql_update = "UPDATE users SET firstname='$firstname', lastname='$lastname', dob='$dob', phone='$phone' WHERE id=$user_id";
        if ($conn->query($sql_update) === TRUE) {
            header("Location: user_information.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    if (isset($_POST['change_password'])) {
        $old_password = md5($_POST['old_password']);
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        $sql_check_old_password = "SELECT * FROM users WHERE id=$user_id AND password='$old_password'";
        $result_check_old_password = $conn->query($sql_check_old_password);

        if ($result_check_old_password->num_rows == 1) {
            if ($new_password == $confirm_password) {
                $hashed_new_password = md5($new_password);
                $sql_update_password = "UPDATE users SET password='$hashed_new_password' WHERE id=$user_id";

                if ($conn->query($sql_update_password) === TRUE) {
                    echo "<script>alert('Password updated successfully.'); window.location='user_information.php';</script>";
                    exit();
                } else {
                    echo "<script>alert('Error updating password: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('New password and confirm password do not match.');</script>";
            }
        } else {
            echo "<script>alert('Old password is incorrect.');</script>";
        }
    }
    if (isset($_POST['update_payment'])) {
        $cardholderName = $_POST['cardholderName'];
        $cardNumber = $_POST['cardNumber'];
        $expiryDate = $_POST['expiryDate'];
        $cvv = $_POST['cvv'];

        $sql_update_payment = "UPDATE payment_detail SET cardholderName='$cardholderName', cardNumber='$cardNumber', expiryDate='$expiryDate', cvv='$cvv' WHERE user_id=$user_id";
        if ($conn->query($sql_update_payment) === TRUE) {
            header("Location: user_information.php");
            exit();
        } else {
            echo "Error updating payment details: " . $conn->error;
        }
    }
    if (isset($_POST['logout'])) {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeFestin - Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Princess+Sofia&display=swap">
    <!-- icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- stylesheet -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="user_information.css">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
</head>

<body>
    <div id="app">
        <header class="header">
            <nav class="navbar">
                <a href="../index.php">Home</a>
                <a href="../index.php#category">Category</a>
                <a href="../index.php#menu">Menu</a>
                <a href="about.php">About</a>
                <a href="newsletter.php">Newsletter</a>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<a href="#">Account</a>';
                }
                ?>
            </nav>
        </header>

        <div class="container">
            <div class="container-left">
                <a href="../index.php" class="logo">LeFestin</a>
                <ul class="links">
                    <hr>
                    <li v-on:click="showComponent('account')">Account</li>
                    <li v-on:click="showComponent('address')">Address</li>
                    <li v-on:click="showComponent('payment')">Payment</li>
                    <li v-on:click="showComponent('history')">Order History</li>
                    <li v-on:click="showComponent('track')">Track Order</li>
                    <hr>
                    <li><a href="#" @click="showComponent('password')">Change Password</a></li>
                    <hr>
                </ul>
            </div>

            <div class="container-right">
                <div v-if="currentComponent === 'account' || currentComponent === 'address' || currentComponent === 'payment' || currentComponent === 'history'" class="popup-form">
                    <div class="popup-content">
                        <template v-if="currentComponent === 'account'">
                            <h2>Account Information</h2>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <label for="firstname">Firstname</label><br>
                                <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>"><br><br>
                                <label for="lastname">Lastname</label><br>
                                <input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>"><br><br>
                                <label for="dob">Date of Birth</label><br>
                                <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>"><br><br>
                                <label for="phone">Phone</label><br>
                                <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>"><br><br>
                                <input type="submit" name="update_info" value="Update">
                            </form>
                        </template>
                        <template v-if="currentComponent === 'address'">
                            <h2>Address Information</h2>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <label for="latitude">Latitude:</label><br>
                                <input type="text" id="latitude" name="latitude" value="<?php echo $latitude; ?>"><br><br>
                                <label for="longitude">Longitude:</label><br>
                                <input type="text" id="longitude" name="longitude" value="<?php echo $longitude; ?>"><br><br>
                                <input type="submit" name="update_address" value="Update Address">
                            </form>
                        </template>

                        <template v-if="currentComponent === 'payment'">
                            <h2>Payment Information</h2>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <label for="cardholderName">Cardholder Name:</label><br>
                                <input type="text" id="cardholderName" name="cardholderName" value="<?php echo $cardholderName; ?>"><br><br>
                                <label for="cardNumber">Card Number:</label><br>
                                <input type="text" id="cardNumber" name="cardNumber" value="<?php echo $cardNumber; ?>"><br><br>
                                <label for="expiryDate">Expiry Date:</label><br>
                                <input type="text" id="expiryDate" name="expiryDate" value="<?php echo $expiryDate; ?>"><br><br>
                                <label for="cvv">CVV:</label><br>
                                <input type="text" id="cvv" name="cvv" value="<?php echo $cvv; ?>"><br><br>
                                <input type="submit" name="update_payment" value="Update Payment">
                            </form>
                        </template>

                        <template v-if="currentComponent === 'history'">
                            <h2>Order History</h2>
                            <table>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Total Items</th>
                                    <th>Menu Items</th>
                                    <th>Total Price</th>
                                    <th>Payment Method</th>
                                    <th>Date</th>
                                </tr>
                                <tr>
                                    <td colspan='6'>
                                        <hr>
                                    </td>
                                </tr>
                                <?php
                                $itemsPerPage = 3; // Number of items per page
                                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page number
                                $offset = ($currentPage - 1) * $itemsPerPage; // Calculate offset

                                $sql_orders = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC LIMIT $offset, $itemsPerPage";
                                $result_orders = $conn->query($sql_orders);

                                if ($result_orders->num_rows > 0) {
                                    while ($order_row = $result_orders->fetch_assoc()) {
                                        $menu_items = $order_row['menu_list'];
                                        $menu_items = explode(',', $menu_items);
                                        echo "<tr>";
                                        echo "<td>" . $order_row['id'] . "</td>";
                                        echo "<td>" . $order_row['total_items'] . "</td>";
                                        echo "<td>";
                                        foreach ($menu_items as $item) {
                                            echo $item . "<br>";
                                        }
                                        echo "</td>";
                                        echo "<td>" . $order_row['total_price'] . "</td>";
                                        echo "<td>" . $order_row['payment_method'] . "</td>";
                                        echo "<td>" . $order_row['created_at'] . "</td>";
                                        echo "</tr>";
                                        echo "<tr><td colspan='6'><hr></td></tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No orders found</td></tr>";
                                }
                                ?>
                            </table>
                            <?php
                            // Pagination
                            $sql_count_orders = "SELECT COUNT(*) AS total FROM orders WHERE user_id = $user_id";
                            $result_count_orders = $conn->query($sql_count_orders);
                            $row_count_orders = $result_count_orders->fetch_assoc();
                            $totalPages = ceil($row_count_orders['total'] / $itemsPerPage);

                            if ($totalPages > 1) {
                                echo "<div class='pagination'>";
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo "<a href='user_information.php?component=history&page=$i' class='page-link'>$i</a>";
                                }
                                echo "</div>";
                            }
                            ?>
                        </template>
                    </div>
                </div>

                <div v-if="currentComponent === 'track'" class="popup-form" id="track_order">
                    <div class="popup-content">
                        <h2>Track Order</h2>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#track_order" method="post">
                            <label for="order_id">Enter Order ID:</label><br>
                            <input type="text" id="order_id" name="order_id"><br><br>
                            <input type="submit" name="track_order" value="Track Order">
                        </form>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['track_order'])) {
                            $order_id = $_POST['order_id'];
                            $sql_track_order = "SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id";
                            $result_track_order = $conn->query($sql_track_order);

                            if ($result_track_order->num_rows > 0) {
                                $order = $result_track_order->fetch_assoc();
                                $menu_items = explode(',', $order['menu_list']);
                                echo "</br><h3>Order ID: " . $order['id'] . "</h3>";
                                echo "<p>Menu Items:</p>";
                                echo "<ul>";
                                foreach ($menu_items as $item) {
                                    $item = trim($item); // Trim whitespace
                                    if (!empty($item)) {
                                        echo "<li>$item</li>";
                                    }
                                }
                                echo "</ul>";
                                echo "<p>Total Items: " . $order['total_items'] . "</p>";
                                echo "<p>Total Price: $" . $order['total_price'] . "</p>";
                                echo "<p>Payment Method: " . $order['payment_method'] . "</p>";
                                echo "<p>Status: ";
                                if ($order['preparing'] == 1) {
                                    echo "Preparing";
                                } elseif ($order['completed'] == 1) {
                                    echo "Completed";
                                } else {
                                    echo "Pending";
                                }
                                echo "</p>";
                            } else {
                                echo "<p>No order found with ID: $order_id</p>";
                            }
                        }
                        ?>
                    </div>
                </div>


                <template v-if="currentComponent === 'password'">
                    <div class="popup-content">
                    <h2>Change Password</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <label for="old_password">Old Password:</label><br>
                        <input type="password" id="old_password" name="old_password"><br><br>
                        <label for="new_password">New Password:</label><br>
                        <input type="password" id="new_password" name="new_password"><br><br>
                        <label for="confirm_password">Confirm New Password:</label><br>
                        <input type="password" id="confirm_password" name="confirm_password"><br><br>
                        <input type="submit" name="change_password" value="Change Password">
                    </form>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@3.4.25/dist/vue.global.min.js"></script>
    <script>
        const app = Vue.createApp({
            data() {
                return {
                    currentComponent: '',
                    isPasswordFormVisible: false,
                    trackOrderSubmitted: <?php echo isset($_POST['track_order']) ? 'true' : 'false'; ?>, // Check if track order form is submitted
                }
            },
            methods: {
                showComponent(component) {
                    this.currentComponent = component;
                },
                showPasswordForm() {
                    this.currentComponent = ''; // Reset current component
                    this.isPasswordFormVisible = true;
                },
                closeAccountPopup() {
                    this.currentComponent = '';
                },
                closePasswordPopup() {
                    this.isPasswordFormVisible = false;
                }
            },
            mounted() {
                const urlParams = new URLSearchParams(window.location.search);
                const track = urlParams.get('track');
                if (track === 'true' || this.trackOrderSubmitted) { // Check if track order form is submitted
                    this.currentComponent = 'track';
                }
            }
        });
        app.mount('#app');
    </script>

</body>

</html>