<?php

require_once 'common.php';
$conn = conn();
//verifying if u have privileges
checkPrivileges();
//edit
//add
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['edited'])) {
    $product = [
        $_POST['title'],
        $_POST['description'],
        (int)$_POST['price'],
        basename($_FILES['image']['name']),
        (int)$_POST['id']
    ];
    validateProduct($product);
    //delete old img for the product
    deleteImageFromStorage($_POST['oldImg']);
    $sql = 'UPDATE products SET title=?, description=?, price=?,image=? WHERE id=?';
    $stmt = $conn->prepare($sql);
    $stmt->execute($product);
    header('Location: products.php');
    exit;
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['add'])) {
    $product = [
        $_POST['title'],
        $_POST['description'],
        (int)$_POST['price'],
        basename($_FILES['image']['name'])
    ];
    validateProduct($product);
    $sql = 'INSERT into products (title,description,price,image) VALUES (?,?,?,?)';
    $stmt = $conn->prepare($sql);
    $stmt->execute($product);
    header('Location: products.php');
    exit;
}
//edit page
if (isset($_GET['id'])) {
    $sql = 'SELECT * FROM products WHERE id =?';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch();
}

require_once 'head.php'; ?>
<div class="container px-4">
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" value="<?= $_GET['id'] ?? '' ?>" name="id">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label"><?= translate('Title of Product') ?></label>
            <input type="text" class="form-control" id="exampleFormControlInput1"
                   value="<?= $product['title'] ?? '' ?>"
                   name="title">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label"><?= translate('Description') ?></label>
            <textarea class="form-control" id="exampleFormControlTextarea1"
                      rows="3"
                      name="description"><?= $product['description'] ?? '' ?>
            </textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">$</span>
            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)"
                   value="<?= $product['price'] ?? '' ?>" name="price">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label"><?= translate('Input your image') ?></label>
            <input class="form-control" type="file" id="formFile" name="image"
                   value="<?= $product['image'] ?? '' ?>">
        </div>
        <input type="hidden" name="oldImg" value="<?= $product['image'] ?? '' ?>">
        <p class="text-50 mb-5" style="color: red"><?= $_GET['error'] ?? '' ?></p>
        <div class="d-grid gap-2 col-4 mx-auto">
            <input class="btn btn-primary" type="submit"
                   name="<?= isset($product) ? 'edited' : 'add' ?>">
        </div>

    </form>
</div>
</body>
</html>
