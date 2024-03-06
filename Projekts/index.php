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

      <!--Teksts-->
      <section id="home">
        <div class="container">
            <h5>JAUNAS PRECES</h5>
            <h1><span>Labākās Ceans</span> Pavasara Sezonā</h1>
            <p>Steidzaties iepirkties (Teksts tiek lietots kā veidne)</p>
            <button class="c-btn1">Iepirkties</button>
        </div>
      </section>

      <!--Brendi-->
      <section id="brand" class="container">
        <div class="row">
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand1.png"/>
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand2.png"/>
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand3.png"/>
            <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand4.png"/>
        </div>
      </section>

      <!--Klases-->
      <section id="new" class="w-100">
        <div class="row p-0 m-0">
            <!--One-->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="assets/imgs/1.png" alt="">
                <div class="details">
                    <h2>Galdaspēles</h2>
                    <button class="btn-buy text-uppercase">Iepirkties</button>
                </div>
            </div>

            <!--Two-->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="assets/imgs/2.png" alt="">
                <div class="details">
                    <h2>Hobija preces</h2>
                    <button class="btn-buy text-uppercase">Iepirkties</button>
                </div>
            </div>

            <!--Three-->
            <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
                <img class="img-fluid" src="assets/imgs/3.png" alt="">
                <div class="details">
                    <h2>Grāmatas</h2>
                    <button class="btn-buy text-uppercase">Iepirkties</button>
                </div>
            </div>
        </div>
      </section>

      <!--Rekomendētie Produkti-->
      <section id="featured" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
          <h3>Mūsu rekomendās preces</h3>
          <hr>
          <p>Šeit mes izvietojām mūsu labākās preces</p>
        </div>
        <div class="row mx-auto container-fluid">

        <?php include('server/get_featured_products.php'); ?>

        <?php while($row= $featured_products -> fetch_assoc()){ ?>

          <div onclick="window.location.href='<?php echo "single_product.php?product_id=".$row['product_id']; ?>';" class="product text-center col-lg-3 col-md-4 col-sm-6 col-sm-12">
        <div class="image-container">
          <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image'] ?>" />
        </div>
        <div class="product-details">
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
          <h4 class="p-price">$<?php echo $row['product_price'] ?></h4>
          <a class="buy-btn btn " href="<?php echo "single_product.php?product_id=".$row['product_id']; ?>">Pirkt</a>
        </div>
      </div>

          <?php } ?>
        </div>
      </section>


      <!--Banner-->
      <section id="banner" class="my-5 py-5">
        <div class="container">
          <h4>PAVASARA SEZONA!</h4>
          <h1>Pavasara kolekcija <br> Līdz 30% atlaides</h1>
          <button class="btn-buy text-uppercase">Iepirkties</button>
        </div>
      </section>

      
      <!--Grāmatas-->
      
      <section id="featured" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
          <h3>Rekomendētās Grāmatas</h3>
          <hr>
          <p>Visvairāk pirktās grāmatas</p>
        </div>
        <div class="row mx-auto container-fluid">

        <?php include('server/get_books.php'); ?>

        <?php while($row= $books_products -> fetch_assoc()){ ?>

          <div onclick="window.location.href='<?php echo "single_product.php?product_id=".$row['product_id']; ?>';" class="product text-center col-lg-3 col-md-4 col-sm-6 col-sm-12">
        <div class="image-container">
          <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image'] ?>" />
        </div>
        <div class="product-details">
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
          <h4 class="p-price">$<?php echo $row['product_price'] ?></h4>
          <a class="buy-btn btn " href="<?php echo "single_product.php?product_id=".$row['product_id']; ?>">Pirkt</a>
        </div>
      </div>
          <?php } ?>
        </div>
        
      </section>



      <!--Footer-->
    <?php include 'assets/includes/footer.php' ?>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
</body>
</html>