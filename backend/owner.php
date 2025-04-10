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

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Check if the user is logged in as owner
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'owner') {
    $user_id = $_SESSION['user_id'];

    // Fetch sales data for each menu item
    if (!empty($search)) {
        $sql_sales = "SELECT item_name, SUM(quantity) AS total_quantity, SUM(total_price) AS total_sales 
                      FROM checkout 
                      WHERE item_name LIKE '%$search%'
                      GROUP BY item_name";
    } else {
        $sql_sales = "SELECT item_name, SUM(quantity) AS total_quantity, SUM(total_price) AS total_sales 
                      FROM checkout 
                      GROUP BY item_name";
    }
    $result_sales = $conn->query($sql_sales);
} else {
    // Redirect if not logged in as owner
    header("Location: ../index.php");
}

// Export to CSV
if (isset($_POST['export'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=sales_data.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, array('Menu Item', 'Total Quantity Sold', 'Total Sales ($)'));
    if ($result_sales->num_rows > 0) {
        while ($row = $result_sales->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Page</title>
    <!-- Bootstrap CSS from CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="owner.css">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Owner Page</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>
    <h1>Welcome, Owner!</h1>

    <div class="container">
        <div class="tb-container">
        <h2>Sales Report</h2>

        <!-- Search Form -->
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Menu Item" aria-label="Search Menu Item" aria-describedby="button-search" name="search" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-secondary" type="submit" id="button-search">Search</button>
            </div>
        </form>

        <!-- Clear Search Button -->
        <?php if (!empty($search)) : ?>
            <form action="" method="GET" class="mb-3">
                <button class="btn btn-secondary btn-clear">Clear</button>
            </form>
        <?php endif; ?>

        <?php
        // Check if there are any results
        if ($result_sales && $result_sales->num_rows > 0) :
        ?>
            <table>
                <tr>
                    <th>Menu Item</th>
                    <th>Total Quantity Sold</th>
                    <th>Total Sales ($)</th>
                </tr>
                <?php
                $total_quantity = 0;
                $total_sales = 0;
                while ($row = $result_sales->fetch_assoc()) :
                    $total_quantity += $row['total_quantity'];
                    $total_sales += $row['total_sales'];
                ?>
                    <tr>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['total_quantity']; ?></td>
                        <td><?php echo number_format($row['total_sales'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
                <tr>
                    <th>Total</th>
                    <td><?php echo $total_quantity; ?></td>
                    <td><?php echo number_format($total_sales, 2); ?></td>
                </tr>
            </table>
        <?php else : ?>
            <p>No sales data available.</p>
        <?php endif; ?>

        <hr>

        <!-- Export Button -->
        <form method="post">
            <input type="submit" name="export" class="btn btn-primary btn-export" value="Export to CSV">
        </form>
        </div>
        <!-- Sales Chart -->
        <div class="chart-container">
        <canvas id="salesChart" width="800" height="400" style="margin-top: 40px;"></canvas>
    </div>
</div>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sales data for Chart.js
        var salesData = {
            labels: [
                <?php
                $result_sales->data_seek(0); // Reset pointer to start
                while ($row = $result_sales->fetch_assoc()) :
                ?>
                    "<?php echo $row['item_name']; ?>",
                <?php endwhile; ?>
            ],
            datasets: [{
                label: 'Total Sales',
                data: [
                    <?php
                    $result_sales->data_seek(0); // Reset pointer to start
                    while ($row = $result_sales->fetch_assoc()) :
                    ?>
                        <?php echo $row['total_sales']; ?>,
                    <?php endwhile; ?>
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Chart.js Configuration
        var salesChartConfig = {
            type: 'bar',
            data: salesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Render Chart
        var ctx = document.getElementById('salesChart').getContext('2d');
        var myChart = new Chart(ctx, salesChartConfig);
    </script>
</body>

</html>

<?php
$conn->close();
?>
