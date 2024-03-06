<?php

/*
    not paid
    paid
    shipped
    delivered
*/

include('server/connection.php');

if(isset($_POST['order_details_btn']) && isset($_POST['order_id'])){

    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ? ");

    $stmt->bind_param('i',$order_id);

    $stmt->execute();

    $order_details = $stmt->get_result();

    $order_total_price = calculateTotalOrderPrice($order_details);

} else {
    header('location: account.php');
    exit;

}


function calculateTotalOrderPrice($order_details){

    $total = 0;

    foreach($order_details as $row) {

        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];

        $total = $total + ($product_price * $product_quantity);

    }
    return $total;
  }
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!--Navbar-->
<?php include 'assets/includes/navbar.php' ?>


<!--Order details-->
<section id="orders" class="orders container my-5 py-3">
            <div class="container mt-5">
                <h2 class="font-weight-bold text-center">Order Details</h2>
                <hr class="mx-auto">
            </div>
    
            <table class="mt-5 pt-5 mx-auto">
                <tr>
                    <th>Produkts</th>
                    <th>Preces cena</th>
                    <th>Daudzums</th>
                </tr>

                <?php foreach($order_details as $row) { ?>

                  <tr>
                    <td>  
                        <div class="product-info">
                            <img src="assets/imgs/<?php echo $row['product_image']; ?>">
                            <div>
                                <p class="mt-3"><?php echo $row['product_name']; ?></p>
                            </div>
                        </div>      
                    </td>
                    
                    <td>
                      <span><p class="mt-3">$<?php echo $row['product_price']; ?></p></span>
                    </td>

                    <td>
                      <span><p class="mt-3"><?php echo $row['product_quantity']; ?></p></span>
                    </td>

                    
                </tr>

             <?php } ?>

            </table>
    
           <?php if($order_status == "not paid"){?>
    
            <form style="float: right;" method="POST" action="payment.php"> 
                <input type="hidden" name="order_total_price" value="<?php echo $order_total_price;?>">
                <input type="hidden" name="order_status" value="<?php echo $order_status; ?>">
                <input type="submit" name="order_pay_btn" class="btn btn-primary" value="Uz nomaksu">
            </form>

            <?php } ?>
        </section>



<!--Footer-->
<?php include 'assets/includes/footer.php' ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
</body>
</html>