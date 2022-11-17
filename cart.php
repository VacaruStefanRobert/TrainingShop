<?php

require_once 'common.php';

$conn = conn();
//get the products
if (!empty($_SESSION['cart'])) {
    $placeHolders = implode(', ', array_fill(0, count($_SESSION['cart']), '?'));
    $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeHolders)");
    $stmt->execute($_SESSION['cart']);
    $products = $stmt->fetchAll();
} else {
    $products = [];
}
//GET TOTAL PRICE
$totalPrice = 0;
foreach ($products as $product) {
    $totalPrice += $product['price'];
}
//checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['checkout'])) {
    // validate form data first before doing anything
    $info = [
        $_POST['name'],
        date("Y-m-d"),
        $_POST['email'],
        $_POST['comments'],
        $_POST['price'],
    ];
    validateForm($info);
    // PREPARE MAIL
    $to = ADMINMAIL;
    $subject = 'Order Placed';
    ob_start();
    include('mail.php');
    $mailText = ob_get_contents();
    ob_end_clean();
    $mailHead = 'MIME-Version: 1.0' . "\r\n" .
        'Content-type: text/html; charset=utf-8' . "\r\n" .
        'From: trainingShop@example.com' . phpversion();
    //  SEND
    if (mail($to, $subject, $mailText, $mailHead)) {
        // if mailing worked, insert data in database
        $sql = 'INSERT INTO orders (name,date,email,comments,price) VALUES (?,?,?,?,?)';
        $stmt = $conn->prepare($sql);
        $stmt->execute($info);
        $orderId = $conn->lastInsertId();
        foreach ($_SESSION['cart'] as $productId) {
            $sql = 'INSERT INTO order_products (product_id,order_id) VALUES (?,?)';
            $stmt = $conn->prepare($sql);
            $stmt->execute([$productId, $orderId]);
        }
        unset($_SESSION['cart']);
        header('Location: index.php');
    } else {
        header('Location: cart.php?errorSend=Failed');
    }
    exit;
}
//remove item
if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['remove'])) {
    $_SESSION['cart'] = array_values(array_diff($_SESSION['cart'], array($_POST['id'])));
    header('Location: cart.php');
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
                        <p class="card-text"><?= translate('Price') ?>: <?= $product['price'] ?> $</p>
                        <form method="POST">
                            <input type="hidden" value="<?= $product['id'] ?>" name="id">
                            <button class="btn btn-primary" type="submit"
                                    name="remove"><?= translate('Remove') ?></button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="container-fluid">
        <form method="POST">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><?= translate('Name') ?></label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="ex: John Doe"
                       name="name">
            </div>
            <p class="text-50 mb-5" style="color: red"><?= $_GET['errorName'] ?? '' ?></p>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"><?= translate('Email') ?></label>
                <input type="email" class="form-control" id="exampleFormControlInput1"
                       placeholder="ex: example@example.com" name="email">
            </div>
            <p class="text-50 mb-5" style="color: red"><?= $_GET['errorMail'] ?? '' ?></p>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1"
                       class="form-label"><?= translate('Comments and details') ?></label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comments"></textarea>
            </div>
            <div class="mb-3">
                <div><?= translate('Price') ?>: <?= $totalPrice ?> $</div>
                <input type="hidden" value="<?= $totalPrice ?>" name="price">
            </div>
            <p class="text-50 mb-5" style="color: red"><?= $_GET['error'] ?? '' ?><?= $_GET['errorSend'] ?? '' ?></p>
            <button class="btn btn-primary" type="submit" name="checkout"><?= translate('Checkout') ?></button>
        </form>
    </div>
<?php else: ?>
    <div><?= translate('No products in cart!') ?></div><br>
<?php endif; ?>
</body>
</html>