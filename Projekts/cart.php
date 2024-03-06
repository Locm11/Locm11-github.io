<?php

session_start();



if (isset($_POST['add_to_cart'])){

  
  if(isset($_SESSION['cart'])){ //Ja lietotājs jau ir pievienojis preci grozaa

    $products_array_ids = array_column($_SESSION['cart'],"product_id"); 
    //Ja prece jau bija pievienota vai nē (pārbauda)
    if(!in_array($_POST['product_id'], $products_array_ids) ) {

      $product_id = $_POST['product_id'];

        $product_array = array(
              'product_id' => $_POST['product_id'],
              'product_name' =>  $_POST['product_name'],
              'product_price' => $_POST['product_price'],
              'product_image' => $_POST['product_image'],
              'product_quantity' => $_POST['product_quantity']
        );

   $_SESSION['cart'][$product_id] = $product_array;

    } else { 

      echo '<script>alert("Prece jau bija pievienota grozā!")</script>';

    }
  
     
  } else {  // Ja pirmais produkts tiek pievienots grozaa

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];
   
   $product_array = array(
        'product_id' => $product_id,
        'product_name' => $product_name,
        'product_price' => $product_price,
        'product_image' => $product_image,
        'product_quantity' => $product_quantity
   );

   $_SESSION['cart'][$product_id] = $product_array;

  }

  //Calculate Total
  calculateTotalCart();


  // preces Noņemšana no groza goddamnit
} elseif (isset($_POST['remove_product'])) {

  $product_id = $_POST['product_id'];
  unset($_SESSION['cart'][$product_id]);
  calculateTotalCart();

} else if(isset($_POST['edit_quantity'])){

  // We get id and quantity from the form
  $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    //get the product array from the session
    $product_array = $_SESSION['cart'][$product_id];
  
    //update product quantity
    $product_array['product_quantity'] = $product_quantity;

    //return array back its place
    $_SESSION['cart'][$product_id] = $product_array;

    calculateTotalCart();
 
} else {
    // header('location: index.php');

}


function calculateTotalCart(){

  $total_price = 0;
  $total_quantity = 0;

    foreach($_SESSION['cart'] as $key => $value) {

     $product = $_SESSION['cart'][$key];

     $price = $product['product_price'];
     $quantity = $product['product_quantity'];

     $total_price = $total_price + ($price * $quantity);
     $total_quantity = $total_quantity + $quantity;

    }
    
    $_SESSION['total'] = $total_price;
    $_SESSION['quantity'] = $total_quantity;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grozs</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

       <!--Navbar-->
       <?php include 'assets/includes/navbar.php' ?>

      <!--Grozs-->
      <section class="container cart my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bold">Jūsu Grozs</h2>
            <hr>
        </div>

        <?php if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) { ?>

        <table class="mt-5 pt-5">
            <tr>
                <th>Prece</th>
                <th>Daudzums</th>
                <th>Summa</th>
            </tr>

            <?php foreach($_SESSION['cart'] as $key => $value) { ?>

            <tr>
                <td>
                    <div class="product-info">
                        <img src="assets/imgs/<?php echo $value['product_image']; ?>"  alt="">
                        <div>
                            <p><?php  echo $value['product_name']; ?></p>
                            <small><span>$</span><?php echo $value['product_price']; ?></small>
                            <br>
                            <form method="POST" action="cart.php">
                              <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                              <input type="submit" name="remove_product" class="remove-btn" href="#" value="Noņemt"/>
                            </form>
                        </div>
                    </div>
                </td>
                <td>
                    
                    <form method= "POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                    <input type="number" name="product_quantity" value="<?php echo max(1, $value['product_quantity']); ?>" min="1">
                    <input type="submit" class="edit-btn" value="Rediģēt" name="edit_quantity"/>
                    </form>
                </td>
                <td>
                    <span class="product-price"><?php echo $value['product_quantity'] * $value['product_price'] ?></span>
                    <span>$</span>
                </td>
            </tr>

            <?php } ?>
            <?php } ?>

        </table>

              

        <div class="cart-total">
            <table>
                <tr>
                    <td>Kopsumma</td>
                    <td>$ <?php echo isset($_SESSION['total']) ? $_SESSION['total'] : 0; ?></td>
                </tr>
            </table>
        </div>
        
        <div class="checkout-container">
            <form method="POST" action="checkout.php">
            <input type="submit" class="c-btn1 checkout-btn" value="Apmaksāt" name="checkout">
            </form>
            
        </div>

      </section>




        <!--Footer-->
        <?php include 'assets/includes/footer.php' ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
</body>
</html>