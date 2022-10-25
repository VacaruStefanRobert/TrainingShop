<?php
session_start();
require_once 'common.php';
$conn = conn();
//remove item
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $_SESSION['cart'] = array_diff($_SESSION['cart'], array($_POST['id']));
}
//get the products
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (!empty($conn)) {
            $product = selectById($conn, $item);
        }
        $products[] = $product;
    }
} else {
    $products = array();
}
?>
<html lang="EN">
<head>
    <title>Cart</title>
</head>
<body>
<h1>Checkout Cart</h1>

<?php if (!empty($products)):
    foreach ($products as $product): ?>
        <div><?php echo "TITLE: " . $product['title'] . "<br>" ?></div>
        <div><?php echo "DESCRIPTION: " . $product['description'] . "<br>" ?></div>
        <div><?php echo "PRICE: " . $product['price'] . "<br>" ?></div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" value="<?= $product['id'] ?>" name="id">
            <button type="submit">Remove</button>
        </form>
        <br>


    <?php endforeach; ?>
    <form action="" method="POST">
        <input type="text" placeholder="Name" name="name">
        <input type="text" placeholder="Contact details" name="name">
        <input type="text" placeholder="Comments" name="name">
        <input type="submit">
    </form>
<?php else: ?>
    <div>No products in cart!</div><br>
<?php endif; ?>

<a href="index.php">Go To Index!</a>
</body>
</html>