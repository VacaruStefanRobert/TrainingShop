<?php
require_once 'common.php';
if (!empty($conn)) {
    $products = selectProducts($conn);
}
?>
<html lang="EN">
<head>
    <title>Shop</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php var_dump($_SESSION['cart']);
foreach ($products as $product):
    ?>
    <div><?php echo "TITLE: " . $product['title'] . "<br>" ?></div>
    <div><?php echo "DESCRIPTION: " . $product['description'] . "<br>" ?></div>
    <div><?php echo "PRICE: " . $product['price'] . "<br>" ?></div>
    <form action="add.php" method="POST">
        <input type="hidden" value="<?=$product['id']?>" name="id">
        <button type="submit">Add</button>
    </form>
    <br>
<?php endforeach;

?>

<a href="cart.php">Go To Cart!</a>
</body>
</html>

