<?php

session_start();

include('server/connection.php');

  // if user has already registered then take user to account page
if(isset($_SESSION['logged_in'])){
  header('location: account.php');
  exit;
}

if(isset($_POST['register'])){

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  //If passwords don't match
  if($password !== $confirmPassword){
    header('location: register.php?error=passwords dont match');
  

  //If password is less than 6 characters
} else if(strlen($password) < 6) {
    header('location: register.php?error=password must be at least 6 charachters');
  

  //If there is no error
} else {
  // check whether there is a user with inputed email
  $stmt1 = $conn->prepare("SELECT count(*) FROM users where user_email=?");
  $stmt1->bind_param('s',$email);
  $stmt1->execute();
  $stmt1->bind_result($num_rows);
  $stmt1->store_result();
  $stmt1->fetch();

  //if there is a user already registered with this email erorr will show
  if($num_rows != 0) {
    header('location: register.php?error=user with this email already exists');
  } else {

  // if no user registered with this email before
  //Create a new user
  $stmt = $conn->prepare("INSERT INTO users (user_name,user_email,user_password)
                          VALUES (?,?,?)");

  $stmt -> bind_param('sss',$name,$email,md5($password));

  // if account was created succesfully
  if ($stmt->execute()){
      $user_id = $stmt->insert_id;
      $_SESSION['user_id'] = $user_id;
      $_SESSION['user_email'] = $email;
      $_SESSION['user_name'] = $name;
      $_SESSION['logged_in'] = true;
      header('location: account.php?register_success=You registered succesfully');

      //account could not be created
  } else {

    header('location: register.php?error=could not create an account at the moment');

       }
    }
  }
  
}







?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reģistrācija</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

        <!--Navbar-->
        <?php include 'assets/includes/navbar.php' ?>
      <!--Register-->
      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Reģistrēties</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="register-form" method="POST" action="register.php">
              <p style="color: red;"><?php if(isset($_GET['error'])) { echo $_GET['error']; }?></p>
                <div class="form-group">
                    <label>Vārds</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="Vārds" required>
                </div>

                <div class="form-group">
                    <label>E-pasts</label>
                    <input type="text" class="form-control" id="register-email" name="email" placeholder="E-pasts" required>
                </div>

                <div class="form-group">
                    <label>Parole</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Parole" required>
                </div>

                <div class="form-group">
                    <label>Apstipriniet paroli</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Parole Atkārtoti" required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" id="register-btn" name="register" value="Reģistrēties">
                </div>

                <div class="form-group">
                   <a id="login-url" href="login.php" class="btn">Jau ir eksistējošs konts? Pieslēgties</a>
                </div>

            </form>
        </div>
      </section>


  <!--Footer-->
  <?php include 'assets/includes/footer.php' ?>
       


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
</body>
</html>