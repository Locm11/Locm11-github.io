<?php

include('server/connection.php');

if(isset($_GET['product_id'])){

  $product_id = $_GET['product_id'];

    $stmt = $conn->prepare("SELECT products.*, product_category.category_name 
                            FROM products 
                            INNER JOIN product_category ON products.category_id = product_category.category_id
                            WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $products = $stmt->get_result();

    //No product id was given
} else {
  header('location: index.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkts</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
   <!--Navbar-->
   <?php include 'assets/includes/navbar.php' ?>
   
      <!--Single product-->

      <section class=" container single-product my-5 py-5">
        <div class="row mt-5">

          <?php while($row = $products->fetch_assoc()){ ?>

     
            <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image'];  ?>" alt="" id="mainImg">
                <div class="small-img-group">
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image'];  ?>" width="100%" class="small-img" alt="">
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image2'];  ?>" width="100%" class="small-img" alt="">
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image3'];  ?>" width="100%" class="small-img" alt="">
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image4'];  ?>" width="100%" class="small-img" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <h6><?php echo ucfirst($row['category_name']);  ?></h6>
                <h3 class="py-4"><?php echo $row['product_name'];  ?></h3>
                <h2>$<?php echo $row['product_price'];  ?></h2>

                <form method="POST" action="cart.php">
              <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?> "/>
              <input type="hidden" name="product_image" value="<?php echo $row['product_image'];  ?>"/>
              <input type="hidden" name="product_name" value="<?php echo $row['product_name'];  ?>"/>
              <input type="hidden" name="product_price" value="<?php echo $row['product_price'];  ?>"/>
              <input type="number" name="product_quantity" value="1"/>
              <button class="buy-btn btn btn-outline-danger" type="submit" name="add_to_cart">Pievienot grozā</button>
              </form>
                <h4 class="mt-5 mb-5">Preces informācija</h4>
                <span>
                <?php echo $row['product_description'];  ?>
                </span>
            </div>

            <?php } ?>
        </div>
      </section>


    <!--Līdzīgas preces-->
      <section id="related-products" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
          <h3>Līdzīgas preces</h3>
          <hr>
          <p>Šeit mes izvietojām mūsu labākās preces</p>
        </div>
        <div class="row mx-auto container-fluid">
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/product1.jpg" />
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            <h5 class="p-name">Produkta nosaukums</h5>
            <h4 class="p-price">$2.99</h4>
            <button class="buy-btn btn btn-outline-danger">Pirkt</button>
          </div>
          
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/product2.jpg" />
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            <h5 class="p-name">Produkta nosaukums</h5>
            <h4 class="p-price">$2.99</h4>
            <button class="buy-btn btn btn-outline-danger">Pirkt</button>
          </div>

          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/product3.png" />
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            <h5 class="p-name">Produkta nosaukums</h5>
            <h4 class="p-price">$2.99</h4>
            <button class="buy-btn btn btn-outline-danger">Pirkt</button>
          </div>

          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/Product4.png" />
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            <h5 class="p-name">Produkta nosaukums</h5>
            <h4 class="p-price">$2.99</h4>
            <button class="buy-btn btn btn-outline-danger">Pirkt</button>
          </div>
        </div>
      </section>



  <!--Footer-->
  <?php include 'assets/includes/footer.php' ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    

    <script>

        var mainImg = document.getElementById("mainImg");
        var smallImg = document.getElementsByClassName("small-img");

        for(let i=0; i<4; i++) {
                smallImg[i].onclick = function(){
                mainImg.src = smallImg[i].src;
            }
        }
        
        


    </script>


</body>
</html>