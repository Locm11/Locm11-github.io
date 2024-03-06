<?php

session_start();
include('../server/connection.php');

include('../assets/includes/check_logged_in_admin.php');

if(isset($_GET['category_id'])){
    $category_id = $_GET['category_id'];
    $stmt = $conn->prepare("DELETE FROM product_category WHERE category_id = ?");
    $stmt->bind_param('i', $category_id);

    if ($stmt->execute()){
        header('location: categories.php?deleted_successfully=Category has been deleted successfully');
    } else {
        header('location: categories.php?deleted_failed=Category has not been deleted successfully');
    }
}

?>