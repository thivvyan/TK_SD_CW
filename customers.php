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

if (isset($_GET['delete'])) {
    $remove_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `customers` WHERE customerid = '$remove_id'");
    header('location:customers.php');
};

if (isset($_POST['edit'])) {
    // Sanitize and escape inputs
    $customerId = mysqli_real_escape_string($conn, stripslashes($_POST['customerId']));
    $firstname = stripslashes($_POST['name']);
    $firstname = mysqli_real_escape_string($conn, $firstname);
    $address = stripslashes($_POST['address']);
    $address = mysqli_real_escape_string($conn, $address);
    $contact = stripslashes($_POST['contactNumber']);
    $contact = mysqli_real_escape_string($conn, $contact);

    $query = "UPDATE `customers` 
              SET name = '$firstname', 
                  address = '$address', 
                  contactNumber = '$contact'
              WHERE customerid = '$customerId'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:customers.php');
    } else {
        echo "<div class='form'>
                <h3>Edit failed. Please try again.</h3><br/>
              </div>";
    }
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
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/customer.css">
</head>

<body>


    <!-- Header -->
    <div class="header">
        <img src="images/logo.png" alt="logo">
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

    <!-- Edit Form -->
    <div class="edit-modal" id="customerForm">
        <form class="form-container" id="editForm" method="post" name="edit">
            <h1>Edit Details</h1>

            <input type="hidden" id="customerId" name="customerId">

            <label for="name"><b>Customer Name</b></label>
            <input type="text" placeholder="Name" id="name" name="name" required>

            <label for="address"><b>Customer Address</b></label>
            <input type="text" placeholder="Enter Address" id="address" name="address" required>

            <label for="contactNumber"><b>Customer Contact Number</b></label>
            <input type="tel" placeholder="Enter Contact Number" id="contactNumber" name="contactNumber" required>

            <button type="submit" class="btn" name="edit">Edit</button>
            <button type="button" class="btn cancel" onclick="closeeditForm()">Close</button>
        </form>
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
                        echo "<td>";
                        echo "<button class='btn btn-primary' onclick='handleEdit(\"" . htmlspecialchars($row['customerId']) . "\", \"" . htmlspecialchars($row['name']) . "\", \"" . htmlspecialchars($row['address']) . "\", \"" . htmlspecialchars($row['contactNumber']) . "\")'>Edit</button>";
                        echo "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-primary' onclick='handleDelete(\"" . htmlspecialchars($row['customerId']) . "\")'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No customers found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function handleEdit(id, name, address, contact) {
            // Reset the form to its default state
            const editForm = document.getElementById("editForm");
            editForm.reset();

            const customerId = document.getElementById('customerId');
            const nameField = document.getElementById('name');
            const addressField = document.getElementById('address');
            const contactField = document.getElementById('contactNumber');

            customerId.value = id;
            nameField.value = name;
            addressField.value = address;
            contactField.value = contact;

            openeditForm();
        }

        function handleDelete(customerId) {
            // Show a confirmation dialog
            if (confirm("Are you sure you want to delete this customer?")) {
                // If the user confirms, redirect to a delete handler or send an AJAX request
                window.location.href = `customers.php?delete=${customerId}`;
            }
        }

        function openeditForm() {
            document.getElementById("customerForm").style.display = "flex";
        }

        function closeeditForm() {
            document.getElementById("customerForm").style.display = "none";
        }
    </script>

</body>

</html>