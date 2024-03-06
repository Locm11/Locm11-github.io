<?php
session_start();
include('../server/connection.php');
?>

<?php
include('../assets/includes/check_logged_in_admin.php');

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

//get all products

$stmt2 = $conn->prepare("SELECT Products.product_id, Products.product_name, Products.product_price, product_category.category_name, Products.product_image
                        FROM Products
                        JOIN product_category ON Products.category_id = product_category.category_id
                        LIMIT ?, ?");
$stmt2->bind_param("ii", $offset, $total_records_per_page);
$stmt2->execute();
$products = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preču Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin_style.css">



</head>
<body>

  <div class="container-fluid">
        <div class="row" >
            <!-- Sidebar -->
            <div class="col-md-3">
                <?php include '../assets/includes/sidemenu.php'; ?>
            </div>
           <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4  mt-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Informācijas Panelis</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                  <div class="btn-group me-2">
                  </div>
                </div>
            </div>

            <h2>Preces</h2>

            <?php if(isset($_GET['edit_success_message'])){ ?>
                <p class="success-message" style="color:green"><?php echo $_GET['edit_success_message'] ?></p>
            <?php } ?>

            <?php if(isset($_GET['edit_failure_message'])){ ?>
                <p class="error-message" style="color:red"><?php echo $_GET['edit_failure_message'] ?></p>
            <?php } ?>

            <?php if(isset($_GET['deleted_successfully'])){ ?>
                <p class="success-message" style="color:green"><?php echo $_GET['deleted_successfully'] ?></p>
            <?php } ?>

            <?php if(isset($_GET['deleted_failed'])){ ?>
                <p class="error-message" style="color:red"><?php echo $_GET['deleted_failed'] ?></p>
            <?php } ?>

            <?php if(isset($_GET['product_created'])){ ?>
                <p class="success-message" style="color:green"><?php echo $_GET['product_created'] ?></p>
            <?php } ?>

            <?php if(isset($_GET['product_failed'])){ ?>
                <p class="error-message" style="color:red"><?php echo $_GET['product_failed'] ?></p>
            <?php } ?>

            <?php if(isset($_GET['images_updated'])){ ?>
                <p class="success-message" style="color:green"><?php echo $_GET['images_updated'] ?></p>
            <?php } ?>

            <?php if(isset($_GET['images_failed'])){ ?>
                <p class="error-message" style="color:red"><?php echo $_GET['images_failed'] ?></p>
            <?php } ?>

            <div class="table-responsive">
              <table class="table  table-striped table-hover table-sm ms-auto">
                <thead>
                  <tr>
                    <th scope="col">Product ID</th>
                    <th scope="col">Preces bilde</th>
                    <th scope="col">Preces nosaukums</th>
                    <th scope="col">Preces cena</th>
                    <!-- <th scope="col">Product Offer </th> -->
                    <th scope="col">Kategorija</th>
                    <!-- <th scope="col">Product Color</th> -->
                    <th scope="col">Rediģēt Bildes</th>
                    <th scope="col">Rediģēt</th>
                    <th scope="col">Dzēst</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($products as $product){?>
                  <tr>
                    <td><?php echo $product['product_id']; ?></td>
                    <td>
                    <img src="../assets/imgs/<?php echo $product['product_image']; ?>" style="width: 70px; height: 70px"/>
                    </td>
                    <td><?php echo $product['product_name']; ?></td>
                    <td><?php echo "$". $product['product_price']; ?></td>
                    <td><?php echo $product['category_name']; ?></td>
                    <td>
                      <a class="btn btn-warning" href="<?php echo "edit_images.php?product_id=".$product['product_id']."&product_name=".$product['product_name']; ?>">Rediģēt Bildes</a>
                    </td>
                    <td>
                      <button class="btn btn-primary" onclick="openEditModal(<?php echo $product['product_id']; ?>); return false;">Rediģēt</button>
                    </td>
                    <td><a class="btn btn-danger" href="delete_product.php?product_id=<?php echo $product['product_id']; ?>">Dzēst</a></td>
                  </tr>
                  <?php } ?>
                  </tbody>
              </table>
              
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
      </main>
    </div>
  </div>


  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div id="editModalContent" class="modal-body p-4">
        <!-- Modal content will be loaded here -->
      </div>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


    <script defer>
  // JavaScript function to open the modal and load product details
  function openEditModal(product_id) {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        document.getElementById('editModalContent').innerHTML = xhr.responseText;
        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
      }
    }
  };

  xhr.open('GET', 'edit_product.php?product_id=' + product_id, true);
  xhr.send();
}
</script>
</body>
</html>
