<?php 

if(!isset($_SESSION['admin_logged_in'])){
    header('location: admin_login.php');
    exit();
  }
  
?>