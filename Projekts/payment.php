<?php
session_start();

if (isset($_POST['order_pay_btn'])) {
    $order_status = $_POST['order_status'];
    $order_total_price = $_POST['order_total_price'];

    // Store the order total in the session
    $_SESSION['total'] = $order_total_price;
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
    <style>
         #paypal-container {
        margin: 0 auto;
    }

    </style>
</head>
<body>

     <!--Navbar-->
     <?php include 'assets/includes/navbar.php' ?>


    <!--Payment-->
    <section class="my-5 py-5 text-center">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Apmaksa</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container text-center">
            
          
       <?php if(isset($_SESSION['total']) && $_SESSION['total'] != 0) { ?>
            <p>Kopējā summa: $ <?php echo $_SESSION['total']; ?></p>
            <input class="btn btn-primary" type="submit" value="Maksāt tagad">
          

        <?php } else if(isset($_POST['order_status']) && $_POST['order_status'] == "not paid"){ ?>
            <p>Total payment: $<?php echo $_POST['order_total_price']; ?></p>
            <input  class="btn btn-primary" type="submit" value="Maksāt tagad">
            

            <?php } else { ?>
                <p>Jums nav pasūtijumu kuri ir jāapmaksā!</p>
            <?php } ?>

            
        </div>
      </section>



   

    <!--Footer-->
    <?php include 'assets/includes/footer.php' ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
</body>
</html>