<?php
require_once 'common.php';
//foreach ($_SESSION['cart'] as $item):
//
//endforeach;
$item=$_SESSION['cart'];
var_dump($item);
$product=selectById($conn,$item);
?>
<html>
<head>
    <title>Cart</title>
</head>
<body>
    <div><?php echo "TITLE: " . $product['title'] . "<br>" ?></div>
    <div><?php echo "DESCRIPTION: " . $product['description'] . "<br>" ?></div>
    <div><?php echo "PRICE: " . $product['price'] . "<br>" ?></div>
    <form action="remove.php" method="POST">
        <input type="hidden" value="<?=$product['id']?>" name="id">
        <button type="submit">Add</button>
    </form>
    <br>

<a href="index.php">Go To Index!</a>
</body>
</html>