<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rare Finds</title>
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet">

</head>

<!-- Error Form -->
<div class="modal" id="loginErrorForm">
  <form class="form-container">
    <h1>Error</h1>
    <h3>Incorrect Username/password.</h3><br />
    <p>Please try again.</p>
    <button type="button" class="btn cancel" onclick="closeLoginError()">Close</button>
  </form>
</div>

<script>
  function openLoginError() {
    document.getElementById("loginErrorForm").style.display = "flex";
  }

  function closeLoginError() {
    document.getElementById("loginErrorForm").style.display = "none";
  }
</script>

<?php

@include 'config.php';
session_start();

if (isset($_SESSION['name'])) {
  $isLoggedIn = true;
} else {
  $isLoggedIn = false;
}

if (isset($_GET['logout'])) {
  session_destroy();

  mysqli_query($conn, "DELETE FROM `shopping_cart`") or die('query failed');

  header('location:index.php');
};

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

  $username = stripslashes($_REQUEST['email']);
  $username = mysqli_real_escape_string($conn, $username);
  $password = stripslashes($_REQUEST['psw']);
  $password = mysqli_real_escape_string($conn, $password);

  $query = "SELECT * FROM `customers` WHERE username='$username' AND password='" . md5($password) . "'";

  $result = mysqli_query($conn, $query) or die();

  $rows = mysqli_num_rows($result);

  if ($rows == 1) {
    $user = mysqli_fetch_assoc($result);

    $_SESSION['username'] = $username;
    $_SESSION['name'] = $user['name'];

    $isLoggedIn = true;

    // Redirect to user dashboard page
    header("Location: index.php");
  } else {
    echo "<script>openLoginError();</script>";
    $isLoggedIn = false;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
  // Sanitize and escape inputs
  $firstname = stripslashes($_POST['name']);
  $firstname = mysqli_real_escape_string($conn, $firstname);
  $address = stripslashes($_POST['address']);
  $address = mysqli_real_escape_string($conn, $address);
  $contact = stripslashes($_POST['contactNumber']);
  $contact = mysqli_real_escape_string($conn, $contact);
  $age = stripslashes($_POST['age']);
  $age = mysqli_real_escape_string($conn, $age);
  $email = stripslashes($_POST['username']);
  $email = mysqli_real_escape_string($conn, $email);
  $password = stripslashes($_POST['password']);
  $password = mysqli_real_escape_string($conn, $password);

  $image = $_FILES['image']['name'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_folder = 'uploaded_img/' . $image;

  // Insert into database
  $query = "INSERT INTO `customers` (name, address, contactNumber, username, password, age, image) 
            VALUES ('$firstname', '$address', '$contact', '$email', '" . md5($password) . "', '$age', '$image')";

  $result = mysqli_query($conn, $query);

  if ($result) {
    move_uploaded_file($image_tmp_name, $image_folder);
    header('location:index.php');
  } else {
    echo "<div class='form'>
              <h3>Registration failed. Please try again.</h3><br/>
              <p class='link'>Click here to <a href='index.php'>register</a> again.</p>
            </div>";
  }
}

?>

<!---Header Yo -->
<div class="container">
  <div class="d-flex justify-content-between align-items-center" style="margin-bottom:5px;">
    <img src="images/logo.png" alt="logo" style="float:left; width: 150px; height:100px;padding-bottom: 5px;margin-top:5px;">
    <form action="index.php" method="POST" class="form-inline d-flex align-items-center" style="width:100%; margin-top:5px;">

      <!-- Search Button -->
      <input class="form-control mr-sm-2" type="search" name="search_query" placeholder="Search" aria-label="Search" style="width: 100%; height: 50px; margin-left: 20px;">
      <button class="header-btn btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>

      <!-- Login Button -->
      <button id="login" class="header-btn btn btn-outline-success my-2 my-sm-0 <?= ($isLoggedIn == true) ? 'display-none' : ''; ?>" onclick="openLoginForm()" type="button">Login</button>

      <!-- Signup Button -->
      <button class="header-btn btn btn-outline-success my-2 my-sm-0 <?= ($isLoggedIn == true) ? 'display-none' : ''; ?>" onclick="openSignupForm()" type="button">Signup</button>

      <div class="header-logged-user <?= ($isLoggedIn == true) ? '' : 'display-none'; ?>" style="margin-left: 20px;">
        <h2>Welcome <?php echo $_SESSION['name'] ?></h2>
      </div>

      <a href="index.php?logout" class="logout-button <?= ($isLoggedIn == true) ? '' : 'display-none'; ?>" onclick="return confirm('Are you sure you want to logout?')">
        <img src="images/icon_logout.png" alt="Logout Icon"> Logout
      </a>

    </form>
  </div>
</div>
<!--Header Close-->

<header class="header">

  <div class="flex">

    <!-- <a href="#" class="logo">Customer Portal</a> -->

    <?php
    $select_rows = mysqli_query($conn, "SELECT * FROM `shopping_cart`") or die('query failed');
    $row_count = mysqli_num_rows($select_rows);
    ?>

    <nav class="navbar" style="width: 100%;">
      <div class="left">
        <a href="index.php"> Home </a>
        <!-- <a href="product.php"> View Products</a> -->
        <a href="contact.php">Contact Us</a>
      </div>
      <div class="right <?= ($isLoggedIn == true) ? '' : 'display-none'; ?>">
        <a href="cart.php">cart <span><?php echo $row_count; ?></span> </a>
      </div>
    </nav>


    <!-- <div id="menu-btn" class="fas fa-bars">
    </div> -->

  </div>

</header>

<body>
  <!-- Login Button Form -->
  <div class="modal" id="loginForm">
    <form class="form-container" method="post" name="login">
      <h1>Login</h1>

      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <button type="submit" class="btn" name="login">Login</button>
      <button type="button" class="btn cancel" onclick="closeLoginForm()">Close</button>
    </form>
  </div>

  <!-- Signup Button Form -->
  <div class="modal" id="signupForm">
    <form method="post" class="form-container" name="register" enctype="multipart/form-data">
      <h1>Sign up</h1>

      <label for="name"><b>Name</b></label>
      <input type="text" placeholder="Enter First Name" name="name" required>

      <label for="address"><b>Address</b></label>
      <input type="text" placeholder="Enter Address" name="address" required>

      <label for="contactNumber"><b>Contact Number</b></label>
      <input type="tel" placeholder="Enter Contact Number" name="contactNumber" required>

      <label for="username"><b>Email</b></label>
      <input type="email" placeholder="Enter Email" name="username" required>

      <label for="age"><b>Age</b></label>
      <input type="number" placeholder="Enter Age" name="age" required>

      <label for="image"><b>Profile Image</b></label>
      <input type="file" name="image" accept="image/png, image/jpg, image/jpeg" required>

      <label for="password"><b>New Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
        required>

      <label for="suVpsw"><b>Verify Password</b></label>
      <input type="password" placeholder="Verify Password" name="suVpsw" id="suVpsw" oninput="verifyPassword()" required>

      <button type="submit" class="btn" name="register">Signup</button>
      <button type="button" class="btn cancel" onclick="closeSignupForm()">Cancel</button>
    </form>
  </div>

  <script>
    function openLoginForm() {
      document.getElementById("loginForm").style.display = "flex";
    }

    function closeLoginForm() {
      document.getElementById("loginForm").style.display = "none";
    }

    function openSignupForm() {
      document.getElementById("signupForm").style.display = "flex";
    }

    function closeSignupForm() {
      document.getElementById("signupForm").style.display = "none";
    }

    function verifyPassword() {
      var input = document.getElementById('suVpsw');
      if (input.value != document.getElementById('password').value) {
        input.setCustomValidity('Password Must be Matching.');
      } else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
      }
    }
  </script>
</body>