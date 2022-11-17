<html lang='EN'>
<h1>Products Order</h1>
<?php foreach ($products as $product) : ?>
    <img src='data:image/x-icon;base64,<?= base64_encode(file_get_contents('images/' . $product['image'])) ?>' alt=''/>
    <ul>
        <li>Product Title: <?= $product['title'] ?></li>
        <li>Product Description: <?= $product['description'] ?></li>
        <li>Product Price: <?= $product['price'] ?>$</li>
    </ul>
<?php endforeach; ?>
</html>
