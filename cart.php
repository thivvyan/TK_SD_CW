<?php

@include 'config.php';

if (isset($_POST['update_update_btn'])) {
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `shopping_cart` SET quantity = '$update_value' WHERE t_id = '$update_id'");
   if ($update_quantity_query) {
      header('location:cart.php');
   };
};

if (isset($_GET['remove'])) {
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `shopping_cart` WHERE t_id = '$remove_id'");
   header('location:cart.php');
};

if (isset($_GET['delete_all'])) {
   mysqli_query($conn, "DELETE FROM `shopping_cart`");
   header('location:cart.php');
}

?>

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>
   <div class="container">

      <section class="shopping-cart">

         <h1 class="heading">shopping cart</h1>

         <table>

            <thead>
               <th>image</th>
               <th>name</th>
               <th>price</th>
               <th>quantity</th>
               <th>total price</th>
               <th>action</th>
            </thead>

            <tbody>

               <?php

               $select_cart = mysqli_query($conn, "SELECT * FROM `shopping_cart`");
               $grand_total = 0;
               if (mysqli_num_rows($select_cart) > 0) {
                  while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
               ?>

                     <tr>
                        <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                        <td><?php echo $fetch_cart['name']; ?></td>
                        <td>$<?php echo number_format($fetch_cart['price']); ?>/-</td>
                        <td>
                           <form action="" method="post">
                              <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['t_id']; ?>">
                              <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                              <input type="submit" value="update" name="update_update_btn">
                           </form>
                        </td>
                        <td>$<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
                        <td><a href="cart.php?remove=<?php echo $fetch_cart['t_id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
                     </tr>
               <?php
                     $grand_total += $sub_total;
                  };
               };
               ?>
               <tr class="table-bottom">
                  <td><a href="product.php" class="option-btn" style="margin-top: 0;">Back</a></td>
                  <td colspan="3">grand total</td>
                  <td>$<?php echo $grand_total; ?>/-</td>
                  <td><a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
               </tr>

            </tbody>

         </table>

         <div class="checkout-btn">
            <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">procced to checkout</a>
         </div>

      </section>

   </div>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>