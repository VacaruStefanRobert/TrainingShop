<?php
session_start();
require 'common.php';
$conn = conn();
//Logout admin
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['logout'])) {
        unset($_SESSION['admin']);
        header('Location: index.php');
    } elseif (isset($_POST['remove'])) {
        removeProduct($conn, $_POST['id']);
    } elseif (isset($_POST['edit'])) {
        header('Location: product.php?id='.$_POST['id']);
    }
}


//verifying if u have privileges
if (isset($_SESSION['admin']) and $_SESSION['admin']) {
    $products = selectProducts($conn);
} else {
    header('Location: index.php');
}
?>
<html lang="EN">
<head>
    <title>Products</title>
</head>
<body>
<h1>Products</h1>
<?php if (!empty($products)):
    foreach ($products as $product):
        ?>
        <div><?php echo "TITLE: " . $product['title'] . "<br>" ?></div>
        <div><?php echo "DESCRIPTION: " . $product['description'] . "<br>" ?></div>
        <div><?php echo "PRICE: " . $product['price'] . "<br>" ?></div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" value="<?= $product['id'] ?>" name="id">
            <button type="submit" name="remove">Remove</button>
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" value="<?= $product['id'] ?>" name="id">
            <button type="submit" name="edit">Edit</button>
        </form>
        <br>
    <?php endforeach;
else: ?>
    <div>No products in shop!</div><br>
<?php endif; ?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <button type="submit" name="logout">Logout!</button>
</form>
</body>
</html>

