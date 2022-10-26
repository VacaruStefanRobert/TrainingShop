<?php
session_start();
require_once 'common.php';
$conn = conn();
//verifying if u have privileges
if (isset($_SESSION['admin']) and $_SESSION['admin']) {
    $product = selectById($conn, $_GET['id']);

} else {
    header('Location: index.php');
}
//edit
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['edit'])) {
    $product = array(
        "id" => (int)$_POST['id'],
        "title" => $_POST['title'],
        "description" => $_POST['description'],
        "price" => (float)$_POST['price'],
        "image" => $_POST['image']
    );

    updateProduct($conn, $product);
    header('Location: products.php');
}

?>
<html lang="EN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<?php require_once 'nav.php' ?>
<div class="container px-4">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" value="<?php echo $_GET['id'] ?>" name="id">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Title of Product</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" value="<?= $product['title'] ?>"
                   name="title">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea class="form-control" id="exampleFormControlTextarea1"
                      rows="3" name="description"><?= $product['description'] ?></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">$</span>
            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)"
                   value="<?= $product['price'] ?>" name="price">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Input your image</label>
            <input class="form-control" type="file" id="formFile" name="image" value="<?= $product['image'] ?>">
        </div>
        <div class="d-grid gap-2 col-4 mx-auto">
            <input class="btn btn-primary" type="submit" name="edit">
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>
</html>
