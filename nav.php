<?php

if (isset($_SESSION['admin']) and $_SESSION['admin']):?>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="products.php"
                       id="products"><?= translate('Products') ?></a>
                    <a class="nav-link active" aria-current="page" href="orders.php"><?= translate('Orders') ?></a>
                    <a class="nav-link active" aria-current="page"
                       href="product.php"><?= translate('Add Product') ?></a>
                    <form  action="login.php" method="POST">
                        <button type="submit" class=" btn btn-outline-light nav-link active" aria-current="page"
                                name="logout"><?= translate('Logout') ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
<?php else: ?>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="index.php"><?= translate('Products') ?></a>
                    <a class="nav-link" href="login.php"><?= translate('Login') ?></a>
                    <a class="nav-link" href="cart.php"><?= translate('Cart') ?></a>
                </div>
            </div>
        </div>
    </nav>
<?php endif;