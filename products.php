<?php

session_start();
require 'common.php';
$conn = conn();
logout($conn);
//remove
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['remove'])) {
    removeProduct($conn, $_POST['id']);
    //If we delete a product we update the session of the cart in case the product is in cart
    if (($key = array_search($_POST['id'], $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
}

//verifying if u have privileges
if (isset($_SESSION['admin']) and $_SESSION['admin']) {
    $products = selectProducts($conn);
} else {
    header('Location: index.php');
    exit();
}
require_once 'head.php';
if (!empty($products)): ?>
    <div class="row row-cols-1 row-cols-md-3 g-4">

        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100">
                    <img src="images/<?= $product['image'] ?>" class="card-img-top img-fluid" alt="">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['title'] ?></h5>
                        <p class="card-text"><?= $product['description'] ?></p>
                        <p class="card-text">Price: <?= $product['price'] ?> $</p>
                        <div class="d-grid gap-2 d-md-block">
                            <form action="" method="POST">
                                <input type="hidden" value="<?= $product['id'] ?>" name="id">
                                <button class="btn btn-primary" type="submit"
                                        name="remove"><?= translate('Remove') ?></button>
                            </form>
                            <form action="" method="POST">
                                <input type="hidden" value="<?= $product['id'] ?>" name="id">
                                <button class="btn btn-primary" type="submit"
                                        name="edit"><?= translate('Edit') ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div>No products in shop!</div><br>
<?php endif; ?>
</body>
</html>

