<?php
session_start();
require_once 'common.php';
$conn = conn();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $_SESSION['cart'][] = $_POST['id'];
    header("Location: cart.php");
}
if (!empty($conn)) {
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
}
?>
<html lang="EN">
<head>
    <title>Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"
          integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Product List</h1>
<?php
if (!empty($products)):
    foreach ($products as $product):
        ?>
        <div><?php echo "TITLE: " . $product['title'] . "<br>" ?></div>
        <div><?php echo "DESCRIPTION: " . $product['description'] . "<br>" ?></div>
        <div><?php echo "PRICE: " . $product['price'] . "<br>" ?></div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" value="<?= $product['id'] ?>" name="id">
            <button type="submit">Add</button>
        </form>
        <br>
    <?php endforeach;
else: ?>
    <div>No products in shop!</div><br>
<?php endif; ?>

<a href="cart.php">Go To Cart!</a><br>
<a href="login.php">Login!</a>
</body>
</html>

