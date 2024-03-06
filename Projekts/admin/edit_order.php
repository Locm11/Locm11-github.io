<?php
session_start(); 
include('../server/connection.php');

include('../assets/includes/check_logged_in_admin.php');


  if(isset($_GET['order_id'])){
    $order_id = $_GET['order_id'];
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param('i',$order_id);
    $stmt->execute();
    $order = $stmt->get_result();
  } else if(isset($_POST['edit_order'])) {

        $order_stauts = $_POST['order_status'];
        $order_id = $_POST['order_id'];


        $stmt = $conn->prepare("UPDATE orders SET order_status=?
                                                WHERE order_id=?");
        $stmt->bind_param('si',$order_stauts,$order_id);

        if($stmt->execute()){
            header('location: dashboard.php?order_updated=Order updated successfully');
        }else{
            header('location: dashboard.php?order_failed=Could not update order');
        }

    }else{
        header('location: dashboard.php');
        exit;
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
    



<h2>Rediģēt Pasūtījumu</h2>

    <div class="mx-auto container">
        <form id="edit-form" method="POST" action="edit_order.php">
            
        <?php foreach($order as $r) ?>

            <p style="color:red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];} ?></p>
            <div class="form-group mt-2">
                <label>Pasutijuma ID</label>
                <p class="my-4"><?php echo $r['order_id']; ?></p>
            </div>

            <div class="form-group mt-2">
                <label>Pasūtijuma kopsumma</label>
                <p class="my-4"><?php echo $r['order_cost']; ?></p>
            </div>

            <input type="hidden" name="order_id" value="<?php echo $r['order_id']; ?>">

            <div class="form-group mt-2">
                <label>Pasūtijuma statuss</label>
                <select class="form-select" required name="order_status">
                    
                    <option value="not paid" <?php if($r['order_status']=='not paid') {echo "selected";} ?>>Not Paid</option>
                    <option value="paid" <?php if($r['order_status']=='paid') {echo "selected";} ?> >Paid</option>
                    <option value="shipped" <?php if($r['order_status']=='shipped') {echo "selected";} ?> >Shipped</option>
                    <option value="delivered" <?php if($r['order_status']=='delivered') {echo "selected";} ?> >Delivered</option>
                </select>
            </div>

            <div class="form-group mt-2">
                <label>Pasūtijuma datums</label>
                <p class="my-4"><?php echo $r['order_date']; ?></p>
            </div>

            <div class="form-group mt-3">
                <input type="submit" class="btn btn-primary" name="edit_order" value="Saglabāt Izmaiņas">
            </div>

        </form>
    </div>


</body>
</html>