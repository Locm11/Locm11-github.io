<?php
session_start();
include('../server/connection.php');
include('../assets/includes/check_logged_in_admin.php');

if (isset($_POST['create_category'])) {
    $category_name = $_POST['category_name'];

    // Validate and sanitize the input as needed
    // ...

    $stmt = $conn->prepare("INSERT INTO product_category (category_name) VALUES (?)");

    if ($stmt) {
        $stmt->bind_param("s", $category_name);

        if ($stmt->execute()) {
            // Category created successfully
            header("Location: categories.php?category_created=Category created successfully");
            exit();
        } else {
            // Log or handle the error
            header("Location: add_category.php?category_failed=Error creating category");
            exit();
        }
    } else {
        // Log or handle the error
        header("Location: add_category.php?category_failed=Error preparing the statement");
        exit();
    }
}
?>

