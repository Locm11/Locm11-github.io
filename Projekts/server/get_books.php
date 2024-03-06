<?php

include('connection.php');


$stmt = $conn->prepare("SELECT * FROM products WHERE category_id='5' LIMIT 4");

$stmt->execute();


$books_products = $stmt->get_result(); //[]


?>