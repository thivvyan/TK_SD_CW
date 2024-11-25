<?php
@include 'config.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin.php");
    exit;
}

// Logout logic
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_destroy();
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/orders.css">
</head>
<body>


<!-- Header -->
<div class="header">
   <img src="images/logo1.png" alt="logo">
   <div class="admin-info">
    <button onclick="window.location.href='add-products.php'" class="btn mr-50">Add Products</button>
    <button onclick="window.location.href='orders.php'" class="btn mr-50">View Orders</button>
       <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
       <a href="?logout=true">Logout</a>
   </div>
</div>

<!-- Sub-header -->
<div class="sub-header">
   <h2>Customers</h2>
</div>


<!-- Customers Table -->
<div class="orders-grid">
    <table>
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Address</th>
                <th>Contact Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch customer records
            $query = "SELECT customerId, username, name, address, contactNumber FROM customers";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['customerId']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['contactNumber']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No customers found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
