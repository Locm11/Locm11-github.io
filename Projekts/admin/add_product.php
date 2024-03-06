<?php
session_start(); 
include('../server/connection.php');

include('../assets/includes/check_logged_in_admin.php');
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
              <h1 class="h2">Informācijas Panelis</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                  <div class="btn-group me-2">
                  </div>
                </div>
            </div>

            <h2>Izveidot Jaunu preci</h2>

            <div class="mx-auto container">
                <form id="create-form" enctype="multipart/form-data" method="POST" action="create_product.php">
                    <p style="color:red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];} ?></p>
                    <div class="form-group mt-3">
                        <label>Nosaukums</label>
                        <input type="text" class="form-control" id="product-name" name="name" placeholder="Nosaukums" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Apraksts</label>
                        <input type="text" class="form-control" id="product-desc" name="description" placeholder="Apraksts" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Cena</label>
                        <input type="number" step="0.01" class="form-control" id="product-price" name="price" placeholder="Cena" required>
                    </div>

                    <div class="form-group mt-3">
                        <label>Kategorija</label>
                        <select class="form-select" required name="category">
                            <?php 
                            // Fetch and iterate through categories
                            $category_query = $conn->query("SELECT * FROM product_category");
                            while ($row = $category_query->fetch_assoc()) {
                                echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label>Bilde 1</label>
                        <input type="file" class="form-control" id="image1" name="image1" placeholder="Bilde 1" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Bilde 2</label>
                        <input type="file" class="form-control" id="image2" name="image2" placeholder="Bilde 2" >
                    </div>
                    <div class="form-group mt-3">
                        <label>Bilde 3</label>
                        <input type="file" class="form-control" id="image3" name="image3" placeholder="Bilde 3" >
                    </div>
                    <div class="form-group mt-3">
                        <label>Bilde 4</label>
                        <input type="file" class="form-control" id="image4" name="image4" placeholder="Bilde 4" >
                    </div>

                    <div class="form-group mt-3">
                        <input type="submit" class="btn btn-primary" name="create_product" value="Izveidot">
                    </div>

                </form>

            </div>

    
</body>
</html>