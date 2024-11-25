<?php
@include 'config.php';

// Handle Admin Registration
if (isset($_POST['register_admin'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // Encrypt password using MD5

    $check_user = mysqli_query($conn, "SELECT * FROM `admin_users` WHERE username = '$username'");
    if (mysqli_num_rows($check_user) > 0) {
        $message = "Username already exists!";
    } else {
        $register_query = mysqli_query($conn, "INSERT INTO `admin_users` (name, username, password) VALUES ('$name', '$username', '$password')");
        $message = $register_query ? "Admin registered successfully!" : "Registration failed!";
    }
}

// Handle Admin Login
if (isset($_POST['login_admin'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // Match encrypted password

    $login_query = mysqli_query($conn, "SELECT * FROM `admin_users` WHERE username = '$username' AND password = '$password'");
    if (mysqli_num_rows($login_query) > 0) {
        session_start();
        $_SESSION['admin_username'] = $username;
        header("Location: orders.php"); // Redirect to orders page
        exit;
    } else {
        $message = "Invalid login credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/admin.css">
   
</head>
<body>
<script>
   function closeLoginForm() {
      document.getElementById('loginModal').classList.remove('active');
      document.getElementById('overlay').classList.remove('active');
    }

    function closeRegisterForm() {
      document.getElementById('registerModal').classList.remove('active');
      document.getElementById('overlay').classList.remove('active');
    }
</script>

<!-- Header Section -->
<div class="header">
   <img src="images/logo1.png" alt="logo">
</div>

<!-- Main Content -->
<div class="btn-container">
   <button class="btn" id="registerBtn">Admin Register</button>
   <button class="btn" id="loginBtn">Admin Login</button>
</div>

<!-- Register Modal -->
<div class="modal" id="registerModal">
   <h3>Admin Register</h3>
   <form action="" method="POST">
       <input type="text" name="name" placeholder="Name" required>
       <input type="text" name="username" placeholder="Username" required>
       <input type="password" name="password" placeholder="Password" required>
       <button type="submit" name="register_admin" class="btn">Register</button>
       <button type="button" class="btn cancel" onclick="closeRegisterForm()">Cancel</button>
   </form>
</div>

<!-- Login Modal -->
<div class="modal" id="loginModal">
   <h3>Admin Login</h3>
   <form action="" method="POST">
       <input type="text" name="username" placeholder="Username" required>
       <input type="password" name="password" placeholder="Password" required>
       <button type="submit" name="login_admin" class="btn">Login</button>
       <button type="button" class="btn cancel" onclick="closeLoginForm()">Cancel</button>
   </form>
</div>

<div class="overlay" id="overlay"></div>

<?php if (isset($message)) { echo "<script>alert('$message');</script>"; } ?>

<script>
   const registerBtn = document.getElementById('registerBtn');
   const loginBtn = document.getElementById('loginBtn');
   const registerModal = document.getElementById('registerModal');
   const loginModal = document.getElementById('loginModal');
   const overlay = document.getElementById('overlay');

   registerBtn.addEventListener('click', () => {
       registerModal.classList.add('active');
       overlay.classList.add('active');
   });

   loginBtn.addEventListener('click', () => {
       loginModal.classList.add('active');
       overlay.classList.add('active');
   });

   overlay.addEventListener('click', () => {
       registerModal.classList.remove('active');
       loginModal.classList.remove('active');
       overlay.classList.remove('active');
   });
</script>

</body>
</html>
