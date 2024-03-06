<?php
session_start();


  if(!isset($_SESSION['admin_logged_in'])){
    header('location: admin_login.php');
    exit();
  }


if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    if (isset($_SESSION['admin_logged_in'])) {
        session_destroy();  // Destroy the session data
        header('location: admin_login.php');  // Redirect to login page
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>
<body>
    <p>You have been logged out. Redirecting to login page...</p>
    <script>
        setTimeout(function() {
            window.location.href = "admin_login.php";
        }, 2000); // Redirect after 2 seconds
    </script>
</body>
</html>