<?php
session_start();
require_once 'common.php';
$conn = conn();
//logout
logout($conn);
//verifying if u have privileges
if (isset($_SESSION['admin']) and $_SESSION['admin'] and isset($_GET['id'])) {
    $product = selectById($conn, $_GET['id']);
} elseif (!(isset($_SESSION['admin']) and $_SESSION['admin'])) {
    header('Location: index.php');
    exit();
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
    exit();
}
//add
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['add'])) {
    $product = array(
        "title" => $_POST['title'],
        "description" => $_POST['description'],
        "price" => (float)$_POST['price'],
        "image" => $_POST['image']
    );
    addProduct($conn, $product);
    header('Location: products.php');
    exit();
}
?>
<?php require_once 'head.php';?>
<div class="container px-4">
    <form action="" method="POST">
        <input type="hidden" value="<?php if (isset($_GET['id'])): echo $_GET['id'];endif;?>" name="id">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Title of Product</label>
            <input type="text" class="form-control" id="exampleFormControlInput1"
                   value="<?php if (isset($product)):echo $product['title'];endif; ?>"
                   name="title">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea class="form-control" id="exampleFormControlTextarea1"
                      rows="3"
                      name="description"><?php if (isset($product)):echo $product['description'];endif; ?>
            </textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">$</span>
            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)"
                   value="<?php if (isset($product)):echo $product['price'];endif; ?>" name="price">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Input your image</label>
            <input class="form-control" type="file" id="formFile" name="image"
                   value="<?php if (isset($product)):echo $product['image'];endif; ?>">
        </div>
        <div class="d-grid gap-2 col-4 mx-auto">
            <input class="btn btn-primary" type="submit"
                   name="<?php if (isset($product)): echo 'edit'; else: echo 'add'; endif; ?>">
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>
</html>
