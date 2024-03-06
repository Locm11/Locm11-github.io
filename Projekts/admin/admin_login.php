<?php

session_start();

include('../server/connection.php');

if(isset($_SESSION['admin_logged_in'])){
  header('location: dashboard.php');
  exit;
}

if(isset($_POST['login_btn'])) {

  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $stmt = $conn->prepare("SELECT admin_id,admin_name,admin_email, admin_password FROM admins WHERE admin_email = ? AND admin_password = ? LIMIT 1");

  $stmt->bind_param('ss',$email,$password);

  if($stmt->execute()){
    $stmt->bind_result($admin_id,$admin_name,$admin_email,$admin_password);
    $stmt->store_result();

    if($stmt->num_rows() == 1){
      $row = $stmt->fetch();

      $_SESSION['admin_id'] = $admin_id;
      $_SESSION['admin_name'] = $admin_name;
      $_SESSION['admin_email'] = $admin_email;
      $_SESSION['admin_logged_in'] = true;

      header('location: dashboard.php?login_success=logged in successfully');

    }else{
      header('location: admin_login.php?error=There is no account with there creditentials');
    }

  }else{
    //error
    header('location: admin_login.php?error=Something went wrong');
  }

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

    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        nav {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 15px;
        }

        nav img {
            max-width: 10%;
            height: auto;
        }
    </style>
</head>
<body>

    <nav>
        <img src="../assets/imgs/alba.png" alt="Logo">
    </nav>

      <!--Login-->
      <section>
        <div class="container text-center mt-3 pt-3">
            <h2 class="form-weight-bold">Administrācijas pieslēgšanās</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" enctype="multipart/form-data" method="POST" action="admin_login.php" >
              <p style="color:red" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error'];} ?></p>
                <div class="form-group">
                    <label>Administrātora E-pasts</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="E-pasts" required>
                </div>
                <div class="form-group">
                    <label>Parole</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Parole" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Pieslēgties">
                </div>
            </form>
        </div>
      </section>



       


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
</body>
</html>