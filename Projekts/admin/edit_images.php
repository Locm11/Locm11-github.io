<?php 
session_start(); 
include('../server/connection.php');

if(isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];
    $product_name = $_GET['product_name'];
} else {
    header('location: products.php');
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
              <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                  <div class="btn-group me-2">
                  </div>
                </div>
            </div>


<h2>Update Product Images</h2>
<div class="table-responsive">

<div class="mx-auto container">
    <form id="edit-image-form" enctype="multipart/form-data" method="post" action="update_images.php">
        <p style="color:red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];} ?></p>
        
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <input type="hidden" name="product_name" value="<?php echo $product_name; ?>">

        <div class="form-group mt-2">
            <label>Image 1</label>
            <input type="file" class="form-control" id="image1" name="image1" placeholder="Image 1" required>
        </div>

        <div class="form-group mt-2">
            <label>Image 2</label>
            <input type="file" class="form-control" id="image2" name="image2" placeholder="Image 2">
        </div>

        <div class="form-group mt-2">
            <label>Image 3</label>
            <input type="file" class="form-control" id="image3" name="image3" placeholder="Image 3">
        </div>

        <div class="form-group mt-2">
            <label>Image 4</label>
            <input type="file" class="form-control" id="image4" name="image4" placeholder="Image 4">
        </div>

        <div class="form-group mt-3">
            <input type="submit" class="btn btn-primary" name="update_images" value="Update">
        </div>


    </form>
</div>
</div>


</body>
</html>