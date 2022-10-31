<?php

session_start();
require_once 'common.php';
$conn = conn();

//added an item to the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['id'])) {
    $_SESSION['cart'][] = $_POST['id'];
    header('Location: cart.php');
    exit();
}
//select the products
if (!empty($_SESSION['cart'])) {
    $products = selectNotInCart($conn, $_SESSION['cart']);
} else {
    $products = selectProducts($conn);
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
                        <p class="card-text"><?= translate('Price') ?>: <?= $product['price'] ?> $</p>
                        <form action="" method="POST">
                            <input type="hidden" value="<?= $product['id'] ?>" name="id">
                            <button class="btn btn-primary" type="submit"><?= translate('Add') ?></button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div><?= translate('No products in shop!') ?></div><br>
<?php endif; ?>

</body>
</html>

