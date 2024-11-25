<?php
session_start();
@include 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: orders.php");
    exit;
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Fetch orders from the database
$orders = [];
$query = "SELECT 
            order_id, 
            name, 
            mobile, 
            email, 
            CONCAT(address_number, ', ', street) AS address, 
            city, 
            state, 
            country, 
            pincode, 
            total_products, 
            total_price 
          FROM order_details";
$result = mysqli_query($conn, $query);
if ($result) {
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
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
    <button onclick="window.location.href='customers.php'" class="btn mr-50">View Customers</button>
       <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
       <a href="?logout=true">Logout</a>
   </div>
</div>

<!-- Sub-header -->
<div class="sub-header">
   <h2>Orders</h2>
</div>

<!-- Orders Grid -->
<div class="orders-grid">
   <table>
       <thead>
           <tr>
               <th>Order ID</th>
               <th>Name</th>
               <th>Mobile</th>
               <th>Email</th>
               <th>Address</th>
               <th>City</th>
               <th>State</th>
               <th>Country</th>
               <th>Pincode</th>
               <th>Products</th>
               <th>Total Price</th>
           </tr>
       </thead>
       <tbody>
           <?php if (!empty($orders)): ?>
               <?php foreach ($orders as $order): ?>
                   <tr>
                       <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                       <td><?php echo htmlspecialchars($order['name']); ?></td>
                       <td><?php echo htmlspecialchars($order['mobile']); ?></td>
                       <td><?php echo htmlspecialchars($order['email']); ?></td>
                       <td><?php echo htmlspecialchars($order['address']); ?></td>
                       <td><?php echo htmlspecialchars($order['city']); ?></td>
                       <td><?php echo htmlspecialchars($order['state']); ?></td>
                       <td><?php echo htmlspecialchars($order['country']); ?></td>
                       <td><?php echo htmlspecialchars($order['pincode']); ?></td>
                       <td><?php echo htmlspecialchars($order['total_products']); ?></td>
                       <td>$<?php echo htmlspecialchars($order['total_price']); ?></td>
                   </tr>
               <?php endforeach; ?>
           <?php else: ?>
               <tr>
                   <td colspan="11" style="text-align: center;">No orders found.</td>
               </tr>
           <?php endif; ?>
       </tbody>
   </table>
</div>

</body>
</html>
