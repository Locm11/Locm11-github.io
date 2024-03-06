<?php

include('server/connection.php');

// This will use the filter section
if (isset($_POST['search'])) {

    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
        //if user has already entered page then page number is the selected one
        $page_no = $_GET['page_no'];
    } else {
        //default page when user enters shop.php
        $page_no = 1;
    }

    $priceFrom = isset($_POST['priceFrom']) ? $_POST['priceFrom'] : 1;
    $priceTo = isset($_POST['priceTo']) ? $_POST['priceTo'] : 1000;
    $categories = $_POST['category'];

    $stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM products
                            INNER JOIN product_category ON products.category_id = product_category.category_id
                            WHERE product_category.category_name IN (?)
                            AND products.product_price BETWEEN ? AND ?");
    $stmt1->bind_param('sii', $category, $priceFrom, $priceTo);
    $stmt1->execute();
    $stmt1->bind_result($total_records);
    $stmt1->store_result();
    $stmt1->fetch();

    // Products per page
    $total_records_per_page = 2;

    $offset = ($page_no - 1) * $total_records_per_page;

    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $adjacents = "2";

    $total_no_of_pages = ceil($total_records / $total_records_per_page);

    $stmt2 = $conn->prepare("SELECT * FROM products
                            INNER JOIN product_category ON products.category_id = product_category.category_id
                            WHERE product_category.category_name IN (?)
                            AND products.product_price BETWEEN ? AND ?
                            LIMIT $offset, $total_records_per_page");
    $stmt2->bind_param('sii', $category, $priceFrom, $priceTo);
    $stmt2->execute();
    $products = $stmt2->get_result();

    // Check if the category array is set and not empty
    if (isset($_POST['category']) && !empty($_POST['category'])) {

        // Create a parameterized string for the IN clause
        $categoryPlaceholders = implode(',', array_fill(0, count($categories), '?'));

        $stmt = $conn->prepare("SELECT products.* FROM products
                                INNER JOIN product_category ON products.category_id = product_category.category_id
                                WHERE product_category.category_name IN ($categoryPlaceholders)
                                AND products.product_price BETWEEN ? AND ?");

        // Bind parameters dynamically
        $bindParams = array_merge($categories, array($priceFrom, $priceTo));
        $stmt->bind_param(str_repeat('s', count($categories)) . 'ii', ...$bindParams);

        $stmt->execute();
        $products = $stmt->get_result();
    } else {
        // No category selected, show all products based on the price range
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_price BETWEEN ? AND ?");
        $stmt->bind_param("ii", $priceFrom, $priceTo);
        $stmt->execute();
        $products = $stmt->get_result();
    }
} else {
    // Show all products
    if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
        //if user has already entered page then page number is the selected one
        $page_no = $_GET['page_no'];
    } else {
        //default page when user enters shop.php
        $page_no = 1;
    }

    $stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM products");
    $stmt1->execute();
    $stmt1->bind_result($total_records);
    $stmt1->store_result();
    $stmt1->fetch();

    //Products per page
    $total_records_per_page = 16;

    $offset = ($page_no - 1) * $total_records_per_page;

    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $adjacents = "2";

    $total_no_of_pages = ceil($total_records / $total_records_per_page);

    // get all products

    $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset, $total_records_per_page");
    $stmt2->execute();
    $products = $stmt2->get_result();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
 
    </style>
</head>
<body>

   <!--Navbar-->
   <?php include 'assets/includes/navbar.php' ?>


  <!--Shop-->
  <section id="featured" class=" container my-5 pb-5">
        <div class="container text-left mt-5 py-5 pt-5">
        <br>
        <br>
          <h3>Mūsu Preces</h3>
          <hr>


          <p class="d-flex justify-content-between align-items-center">
            Šeit mes izvietojām mūsu labākās preces
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter"></i> Filtrācija
            </button>
          </p>


        </div>
        <div class="row mx-auto container-fluid">

        <?php while($row = $products->fetch_assoc()) { ?>
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


      <nav aria-label="Page navigation example">
          <ul class="pagination mt-5">

            <li class="page-item <?php if($page_no<=1) {echo 'disabled';} ?>">
                <a class="page-link" href="<?php if($page_no <=1) {echo '#';}else{ echo "?page_no=".($page_no-1);}?>">Previous</a>
            </li>


            <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
            <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>

            <?php if( $page_no >=3){ ?>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo "?page_no=".$page_no; ?>"><?php echo $page_no; ?></a></li>
            <?php } ?>
 
            <li class="page-item <?php if($page_no>= $total_no_of_pages) {echo 'disabled';}?>">
                <a class="page-link" href="<?php if($page_no >= $total_no_of_pages){echo '#';} else { echo "?page_no=".($page_no+1);} ?>">Next</a>
            </li>
          </ul>
      </nav>

    </div>
  </section>

<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Options</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">
                <!-- Filter content -->
                <section id="search" class="col-lg-12 my-1 py-1 filter-section">
                    <div class="mt-3 py-3">
                        <p>Search Products</p>
                        <hr>
                    </div>

                    <form action="shop.php" method="POST">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <p>Category</p>
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM product_category");
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" value="<?= $row['category_name'] ?>" type="checkbox" name="category[]" id="category_<?= $row['category_name'] ?>" <?php if (isset($categories) && in_array($row['category_name'], $categories)) echo 'checked'; ?>>
                                            <label class="form-check-label" for="category_<?= $row['category_name'] ?>">
                                                <?= ucfirst($row['category_name']) ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <p>Price Range</p>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="priceFrom">From</label>
                                        <input type="number" class="form-control" name="priceFrom" id="priceFrom" placeholder="Enter min price" value="<?= isset($priceFrom) ? $priceFrom : 1 ?>">
                                    </div>
                                    <div class="col-6">
                                        <label for="priceTo">To</label>
                                        <input type="number" class="form-control" name="priceTo" id="priceTo" placeholder="Enter max price" value="<?= isset($priceTo) ? $priceTo : 1000 ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="modal-footer">
                                        <input type="submit" name="search" value="Search" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
  
    
 
    <!--Footer-->

<?php include 'assets/includes/footer.php' ?>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
</body>
</html>