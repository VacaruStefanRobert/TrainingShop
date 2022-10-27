<?php
session_start();
require 'common.php';
$conn = conn();
logout();
//remove
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['remove'])) {
    removeProduct($conn, $_POST['id']);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<?php require_once 'nav.php'; ?>
<?php if (!empty($products)): ?>
    <div class="row row-cols-1 row-cols-md-3 g-4">

        <?php foreach ($products as $product):
            ?>
            <div class="col">
                <div class="card h-100">
                    <img src="images/<?= $product['image'] ?>" class="card-img-top img-fluid" alt="">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['title'] ?></h5>
                        <p class="card-text"><?= $product['description'] ?></p>
                        <p class="card-text">Price: <?= $product['price'] ?> $</p>
                        <div class="d-grid gap-2 d-md-block">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <input type="hidden" value="<?= $product['id'] ?>" name="id">
                                <button class="btn btn-primary" type="submit" name="remove">Remove</button>
                            </form>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <input type="hidden" value="<?= $product['id'] ?>" name="id">
                                <button class="btn btn-primary" type="submit" name="edit">Edit</button>
                            </form>
                        </div>
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

