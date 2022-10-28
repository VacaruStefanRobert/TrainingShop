<?php

session_start();
require_once 'common.php';
$conn = conn();
redirectAdmin();
//remove item
if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['remove'])) {
    $_SESSION['cart'] = array_diff($_SESSION['cart'], array($_POST['id']));
    unset($_POST['remove']);
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
//checkout
if ($_SERVER['REQUEST_METHOD'] = 'POST' and isset($_POST['checkout'])) :
    $info = array(
        "name" => $_POST['name'],
        "date" => date("Y-m-d"),
        "email" => $_POST['email'],
        "comments" => $_POST['comments'],
        "price" => $_POST['price'],
        "products" => json_encode($_SESSION['cart'])
    );
    $to = ADMINMAIL;
    $subject = 'Order Placed';

    $mailBody = "<html lang='EN'>
    <h1>Products Order</h1>";
    foreach ($products as $product) {
        //encode img to be sent
        $img = file_get_contents('images/' . $product['image']);
        $imgData = base64_encode($img);

        $mailBody .= "<img src='data:image/x-icon;base64,$imgData' alt=''/>
            <ul>
            <li>Product Title: " . $product['title'] . "</li>
            <li>Product Description: " . $product['description'] . "</li>
            <li>Product Pirce: " . $product['price'] . "$</li>
            </ul>";
    }
    $mailBody .= "</html>";
    // HEADER - HTML MAIL
    $mailHead = implode("\r\n", [
        "MIME-Version: 1.0",
        "Content-type: text/html; charset=utf-8",
        'From: trainingShop@example.com'
    ]);

//  SEND
    if (mail($to, $subject, $mailBody, $mailHead)):
        addOrder($conn, $info);
        echo '<script>alert("Checkout successful!");window.location.href="../TrainingShop/index.php";</script>';
        unset($_SESSION['cart']);
    else:
        echo '<script>alert("Checkout unsuccessful!");window.location.href="../TrainingShop/cart.php";
                </script>';
    endif;

else:
     require_once 'head.php';
     if (!empty($products)):
        $price = 0;
        ?>
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
                            <form action="" method="POST">
                                <input type="hidden" value="<?= $product['id'] ?>" name="id">
                                <button class="btn btn-primary" type="submit" name="remove">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                $price = $price + $product['price'];
            endforeach; ?>
        </div>
        <div class="container-fluid">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="ex: John Doe"
                           name="name">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1"
                           placeholder="ex: example@example.com" name="email">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Comments and details</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comments"></textarea>
                </div>
                <div class="mb-3">
                    <div>Price: <?= $price ?> $</div>
                    <input type="hidden" value="<?= $price ?>" name="price">
                </div>
                <button class="btn btn-primary" type="submit" name="checkout">Checkout</button>
            </form>
        </div>
    <?php else: ?>
        <div>No products in cart!</div><br>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>
    </body>
    </html>
<?php endif;