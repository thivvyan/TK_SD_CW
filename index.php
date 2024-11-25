<?php
@include 'config.php';

if (isset($_POST['add_to_cart'])) {
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_POST['product_image'];
  $product_quantity = 1;

  $select_cart = mysqli_query($conn, "SELECT * FROM `shopping_cart` WHERE name = '$product_name'");

  if (mysqli_num_rows($select_cart) > 0) {
    $message[] = 'product already added to cart';
  } else {
    $insert_product = mysqli_query($conn, "INSERT INTO `shopping_cart`(name, price, image, quantity) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
    $message[] = 'product added to cart successfully';
  }
}
?>
<?php include 'header.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rare Finds</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!--Carousel-->
  <div id="carouselExample" class="carousel slide" style="background-color: #777;">
    <div class="carousel-inner"
      style="background-color: #777; object-fit:cover; margin-left: auto; margin-right: auto;">
      <div class="carousel-item active">
        <img src="Images/cover2.jpg" class="d-block w-100" style="object-fit:cover;" alt="Artefact 01">
      </div>
      <div class="carousel-item">
        <img src="Images/cover1.jpg" class="d-block w-100" style="object-fit:cover;" alt="Aretefact 02">
      </div>
      <div class="carousel-item">
        <img src="Images/cover3.jpg" class="d-block w-100" style="object-fit:cover;" alt="Aretefact 03">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!--Carousel Close-->

  <?php
  if (isset($message)) {
    foreach ($message as $message) {
      echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i></div>';
    }
  }
  ?>

  <!--Products-->
  <section class="container mt-5">
    <?php
    // Fetch the latest 9 products from the product table
    $query = "SELECT * FROM `product` ORDER BY product_id DESC LIMIT 9";
    $result = mysqli_query($conn, $query) or die();
    $products = mysqli_fetch_assoc($result);
    ?>


    <div class="container">
      <h2 class="text-center" style="margin-top: 5%;">Recent Additions</h2>

      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `product` ORDER BY product_id DESC LIMIT 9");
        if (mysqli_num_rows($select_products) > 0) {
          while ($product = mysqli_fetch_assoc($select_products)) {

            $itemName = $product['name'];
            $item = mysqli_query($conn, "SELECT * FROM `shopping_cart` WHERE name = '$itemName'");

            if (mysqli_num_rows($item) > 0) {
              $itemAddedToCart = true;
            } else {
              $itemAddedToCart = false;
            }
        ?>
            <div class="col" style="margin-top: 3%;">
              <div class="card h-100">
                <img src="uploaded_img/<?php echo $product['image']; ?>" alt="" class="card-img-top" style="height:300px">
                <div class="card-body">
                  <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                  <p class="card-text">$<?php echo htmlspecialchars($product['price']); ?></p>
                  <button type="button" class="btn btn-primary mt-auto" onclick="addToCartClicked('<?php echo $product['name']; ?>', '<?php echo $product['price']; ?>', '<?php echo $product['image']; ?>', '<?php echo $isLoggedIn; ?>')"><?php echo ($itemAddedToCart == true) ? 'Added to cart' : 'Add to cart'; ?></button>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<p class='text-center'>No products found.</p>";
        }
        ?>
      </div>
    </div>

    <script>
      function addToCartClicked(name, price, image, isLoggedIn) {
        if (isLoggedIn == false){
          document.getElementById("login").click();
          return;
        }
        const formData = new URLSearchParams();
        formData.append('add_to_cart', true);
        formData.append('product_name', name);
        formData.append('product_price', price);
        formData.append('product_image', image);

        fetch('index.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formData.toString(),
          })
          .then(data => {
            // if (data.success) {
            //   buttonElement.textContent = 'Added to Cart';
            //   buttonElement.disabled = true;
            // } else {
            //   alert(data.message);
            // }
            location.reload();
          })
          .catch(error => console.error('Error:', error));
      }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"> </script>
    <script src="scripts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Initialize the popover
      var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
      var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
          trigger: 'focus', // Ensures popover closes when clicking outside
        });
      });
    </script>

  </section>

  <!--Footer-->
  <div class="container-fluid" style="width:100%;">
    <footer class="bg-dark text-white mt-4 p-4 text-center" style="width:auto; height: 50px;">
      <p>&copy; 2024 Artefact Shop. All rights reserved.</p>
    </footer>
  </div>

</body>

</html>