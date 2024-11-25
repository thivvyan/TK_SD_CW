<?php
@include 'config.php';
?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rare Finds</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rare Finds</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet">
  
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!--Input Section-->
  <section class="container mt-5">
    <div class="row">
      <!-- <form class="w3-container">

            <label class="w3-text-black"><b>First Name</b></label>
            <input class="w3-input w3-border" type="text">
             
            <label class="w3-text-black" style="margin-top: 2%;"><b>Last Name</b></label>
            <input class="w3-input w3-border" type="text">

            <label class="w3-text-black" style="margin-top: 2%;"><b>Email</b></label>
            <input class="w3-input w3-border" type="text" inputmode="email">

            <label class="w3-text-black" style="margin-top: 2%;"><b>Message</b></label>
            <input class="w3-input w3-border" type="text">
            
            <button class="w3-btn w3-blue" style="margin-top: 5%;">Register</button>
             
        </form> -->

      <form action="/action_page.php" class="w3-container w3-card-4 w3-light-grey w3-text-black w3-margin">
        <h2 class="w3-center">Contact Us</h2>

        <div class="w3-row w3-section">
          <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-border" name="fullname" type="text" placeholder="Full Name">
          </div>
        </div>

        <div class="w3-row w3-section">
          <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-border" name="email" type="email" placeholder="Email">
          </div>
        </div>

        <div class="w3-row w3-section">
          <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-phone"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-border" name="phone" type="text" placeholder="Phone">
          </div>
        </div>

        <div class="w3-row w3-section">
          <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-pencil"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-border" name="message" type="text" placeholder="Message">
          </div>
        </div>

        <button class="w3-button w3-block w3-section w3-black w3-ripple w3-padding">Send</button>

      </form>
    </div>
    <!--Footer-->
    <div class="container-fluid" style="width:100%;">
      <footer class="bg-dark text-white mt-4 p-4 text-center" style="width:auto; height: 50px;">
        <p>&copy; 2024 Artefact Shop. All rights reserved.</p>
      </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"> </script>
    <script src="scripts.js"></script>
</body>

</html>