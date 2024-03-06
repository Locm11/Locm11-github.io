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
    <title>Izveidot Jaunu Kategoriju</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <?php include '../assets/includes/sidemenu.php'; ?>
            </div>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Informācijas Panelis</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                        </div>
                    </div>
                </div>

                <h2>Izveidot Jaunu Kategoriju</h2>

                <div class="mx-auto container">
                    <form id="create-category-form" method="POST" action="create_category.php">
                        <p style="color: red;"><?php if (isset($_GET['category_failed'])) {
                                                    echo $_GET['category_failed'];
                                                } ?></p>
                        <div class="form-group mt-3">
                            <label>Kategorijas nosaukums</label>
                            <input type="text" class="form-control" id="category-name" name="category_name" placeholder="Kategorijas nosaukums" required>
                        </div>

                        <div class="form-group mt-3">
                            <input type="submit" class="btn btn-primary" name="create_category" value="Izveidot">
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>