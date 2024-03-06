<?php 
session_start();

include('../server/connection.php');

include('../assets/includes/check_logged_in_admin.php');

if(isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];

    // Fetch product and category information using a JOIN
    $stmt = $conn->prepare("SELECT p.*, c.category_name 
                            FROM products p
                            JOIN product_category c ON p.category_id = c.category_id
                            WHERE p.product_id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        // Handle case when product is not found
        header('location: products.php?error=Product not found');
        exit();
    }
} else if(isset($_POST['edit_btn'])){
    // Retrieve form data
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Update the product using prepared statement
    $stmt = $conn->prepare("UPDATE products SET product_name=?, product_description=?, product_price=?, category_id=? 
                            WHERE product_id=?");
    $stmt->bind_param('ssdsi', $name, $description, $price, $category, $product_id);

    if($stmt->execute()){
        header('location: products.php?edit_success_message=Product updated successfully');
    } else {
        header('location: products.php?edit_failure_message=Could not update product');
    }

} else {
    header('location: products.php');
    exit();
}
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

   
</head>
<body>
    



<h2>Rediģēt Preci</h2>

<div class="mx-auto container">
    <form id="edit-form" method="POST" action="edit_product.php">
        <p style="color:red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];} ?></p>
        <div class="form-group mt-2">

            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>" >

            <div class="form-group mt-2">
                <label>Preces Nosaukums</label>
                <input type="text" class="form-control" id="product-name" value="<?php echo $product['product_name']; ?>" name="name" placeholder="Product Name" required>
            </div>
            <div class="form-group mt-2">
                <label>Cena</label>
                <input type="text" class="form-control" id="product-name" value="<?php echo $product['product_price']; ?>" name="price" placeholder="Product Name" required>
            </div>
            <div class="form-group mt-2">
                <label>Preces Apraksts</label>
                <textarea class="form-control" id="product-description" name="description" placeholder="Product Description" rows="5" required><?php echo $product['product_description']; ?></textarea>
            </div>
            <div class="form-group mt-2">
                <label>Preces kategorija</label>
                <select class="form-select" required name="category">
                    <?php 
                    // Fetch and iterate through categories
                    $category_query = $conn->query("SELECT * FROM product_category");
                    while ($row = $category_query->fetch_assoc()) {
                        $selected = ($row['category_id'] == $product['category_id']) ? 'selected' : '';
                        echo "<option value='{$row['category_id']}' $selected>{$row['category_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group mt-3">
                <input type="submit" class="btn btn-primary" name="edit_btn" value="Saglabāt Izmaiņas">
            </div>
        </div>
    </form>
</div>


</body>
</html>