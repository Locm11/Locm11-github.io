<?php 
session_start();
?>


<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/imgs/alba.png" alt="Logo" class="navbar-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Mājaslapa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Preces</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Mūsu kontakti</a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="cart.php" class="cart-link me-3">
                    <i class="fas fa-shopping-cart"></i>
                    <?php if(isset($_SESSION['quantity']) && $_SESSION['quantity'] != 0) { ?>
                        <span class="cart-quantity"><?php echo $_SESSION['quantity']; ?></span>
                    <?php } ?>
                </a>
                <a href="account.php" class="user-link">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </div>
    </div>
</nav>