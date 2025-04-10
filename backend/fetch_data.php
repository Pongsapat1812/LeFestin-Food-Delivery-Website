<?php
session_start();

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

if (isset($_SESSION['user_id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_SESSION['user_id'];
        $cartItems = json_decode($_POST['cart_items'], true);
        saveCartItems($user_id, $cartItems, $conn);
        exit("Cart items saved successfully");
    }
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// Default sorting parameters for users
$user_sort = isset($_GET['user_sort']) ? $_GET['user_sort'] : 'id';
$user_order = isset($_GET['user_order']) ? $_GET['user_order'] : 'ASC';

// Sorting validation for users
$user_sort_whitelist = ['id', 'firstname', 'lastname', 'role', 'registration_timestamp'];
$user_order_whitelist = ['ASC', 'DESC'];

if (!in_array($user_sort, $user_sort_whitelist)) {
    $user_sort = 'id';
}

if (!in_array($user_order, $user_order_whitelist)) {
    $user_order = 'ASC';
}

// Fetch all users
$search_users = isset($_GET['search_users']) ? $conn->real_escape_string($_GET['search_users']) : '';

$sql_users = "SELECT * FROM users";

if (!empty($search_users)) {
    $sql_users .= " WHERE firstname LIKE '%$search_users%' OR lastname LIKE '%$search_users%' OR email LIKE '%$search_users%' OR role LIKE '%$search_users%'";
}

$sql_users .= " ORDER BY $user_sort $user_order";

$result_users = $conn->query($sql_users);

$users = [];
if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row;
    }
}

// Default sorting parameters for team members
$team_sort = isset($_GET['team_sort']) ? $_GET['team_sort'] : 'team_id';
$team_order = isset($_GET['team_order']) ? $_GET['team_order'] : 'ASC';

// Sorting validation for team members
$team_sort_whitelist = ['team_id', 'role'];
$team_order_whitelist = ['ASC', 'DESC'];

if (!in_array($team_sort, $team_sort_whitelist)) {
    $team_sort = 'team_id';
}

if (!in_array($team_order, $team_order_whitelist)) {
    $team_order = 'ASC';
}

// Fetch all team members
$search_team = isset($_GET['search_team']) ? $conn->real_escape_string($_GET['search_team']) : '';

$sql_team = "SELECT * FROM team";

if (!empty($search_team)) {
    $sql_team .= " WHERE email LIKE '%$search_team%' OR role LIKE '%$search_team%'";
}

$sql_team .= " ORDER BY $team_sort $team_order";

$result_team = $conn->query($sql_team);

$team = [];
if ($result_team->num_rows > 0) {
    while ($row = $result_team->fetch_assoc()) {
        $team[] = $row;
    }
}

// Fetch all login attempts
$sql_login_attempts = "SELECT * FROM login_attempts";
$result_login_attempts = $conn->query($sql_login_attempts);

$login_attempts = [];
if ($result_login_attempts->num_rows > 0) {
    while ($row = $result_login_attempts->fetch_assoc()) {
        $login_attempts[] = $row;
    }
}
?>
