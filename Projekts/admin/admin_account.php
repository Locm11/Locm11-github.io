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
    <title>Improved Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <style>
        .container {
            background-color: #f8f9fa; /* Light gray background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            margin-top: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 10px;
        }
    </style>


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
              <h1 class="h2">Administrācijas profils</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                  <div class="btn-group me-2">
                  </div>
                </div>
            </div>

            <div class="container">
                <p>Id: <?php echo $_SESSION['admin_id']; ?></p>
                <p>Vārds: <?php echo $_SESSION['admin_name']; ?></p>
                <p>E-pasts: <?php echo $_SESSION['admin_email']; ?></p>
            </div>
            </main>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4  mt-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Palīdzība</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                  <div class="btn-group me-2">
                  </div>
                </div>
            </div>

            <div class="container">
               <p>Ja jums ir kādi jautājumi, lūdzu sazinieties ar mums</p>
                <p>E-pasts: 6KwZ6@example.com</p>
                <p>Vai arī</p>
                <p>Telefona numurs: 0123456789</p>
            </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>
</html>