<?php

session_start();
require_once 'common.php';
$conn = conn();
redirectAdmin();
//added an item to the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($POST['id'])) {
    $_SESSION['cart'][] = $_POST['id'];
    header('Location: cart.php');
    exit();
}
//select the products
$products = selectProducts($conn);

if (!empty($_SESSION['cart'])) {
    $index = 0;
    foreach ($products as $product) {
        if (in_array((string)$product['id'], $_SESSION['cart'])) {
            unset($products[$index]);
        }
        $index++;
    }
    $products = array_values($products);
}
?>
<?php require_once 'head.php';?>
<?php if (!empty($products)): ?>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100">
                    <img src="images/<?= $product['image'] ?>" class="card-img-top img-fluid" alt="">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['title'] ?></h5>
                        <p class="card-text"><?= $product['description'] ?></p>
                        <p class="card-text">Price: <?= $product['price'] ?> $</p>
                        <form action="" method="POST">
                            <input type="hidden" value="<?= $product['id'] ?>" name="id">
                            <button class="btn btn-primary" type="submit">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div>No products in shop!</div><br>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>
</html>

