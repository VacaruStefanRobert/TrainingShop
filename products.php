<?php

require 'common.php';

$conn = conn();
checkPrivileges();
$products = selectProducts($conn);
//remove
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $sql = 'DELETE FROM products WHERE id=?';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['id']]);
    //NEED TO DELETE THE FILE ALSO FROM SERVER
    deleteImageFromStorage(array_column($products, null, 'id')[$_POST['id']]['image'] ?? false);
    //If we delete a product we update the session of the cart in case the product is in cart
    if (isset($_SESSION['cart']) && ($key = array_search($_POST['id'], $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
    header('Location: products.php');
    exit;
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
                            <a class="btn btn-primary"
                               href="product.php?id=<?= $product['id'] ?>"><?= translate('Edit') ?></a>
                        </div>
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

