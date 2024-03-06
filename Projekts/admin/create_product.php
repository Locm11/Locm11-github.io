<?php
session_start(); 
include('../server/connection.php');
include('../assets/includes/check_logged_in_admin.php');

if(isset($_POST['create_product'])) {
    $product_name = $_POST['name'];
    $product_description = $_POST['description'];
    $product_price = sprintf("%.2f", floatval($_POST['price']));
    $product_category = $_POST['category'];

    // Create a mapping for Latvian characters to their non-special equivalents
    $latvianToNormal = array(
        'Ā' => 'A',
        'Č' => 'C',
        'Ķ' => 'K',
        'Ģ' => 'G',
        'Ī' => 'I',
        'Ķ' => 'K',
        'Š' => 'S',
        'Ū' => 'U',
        'Ž' => 'Z',
        'Ļ' => 'l',
        'ā' => 'a',
        'č' => 'c',
        'ē' => 'e',
        'ī' => 'i',
        'ķ' => 'k',
        'š' => 's',
        'ū' => 'u',
        'ž' => 'z',
        'ļ' => 'l'
    );

    // Replace Latvian characters with their non-special equivalents
    $product_name = strtr($product_name, $latvianToNormal);

    $image1 = $_FILES['image1']['tmp_name'];
    $image2 = $_FILES['image2']['tmp_name'];
    $image3 = $_FILES['image3']['tmp_name'];
    $image4 = $_FILES['image4']['tmp_name'];

    $image_name1 = $product_name . "1.jpeg";
    $image_name2 = $product_name . "2.jpeg";
    $image_name3 = $product_name . "3.jpeg";
    $image_name4 = $product_name . "4.jpeg";

    move_uploaded_file($image1, "../assets/imgs/" . $image_name1);
    move_uploaded_file($image2, "../assets/imgs/" . $image_name2);
    move_uploaded_file($image3, "../assets/imgs/" . $image_name3);
    move_uploaded_file($image4, "../assets/imgs/" . $image_name4);

    $stmt = $conn->prepare("INSERT INTO products (product_name, product_description, product_price, category_id,
                                product_image, product_image2, product_image3, product_image4)
                            VALUES (?,?,?,?,?,?,?,?)");

    $stmt->bind_param('ssdsssss', $product_name, $product_description, $product_price, $product_category,
        $image_name1, $image_name2, $image_name3, $image_name4);

    if ($stmt->execute()){
        header('location: products.php?product_created=Product has been added successfully');
    } else {
        header('location: products.php?product_failed=Product has not been added successfully');
    }
}
?>
