<?php
session_start();
require_once 'common.php';
$conn = conn();
logout($conn);
$orders = selectOrders($conn);
//verifying if u have privileges
if (!(isset($_SESSION['admin']) and $_SESSION['admin'])) {
    header('Location: index.php');
}
?>
<html lang="EN">
<head>
    <title>Orders</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<?php require_once 'nav.php' ?>
<?php foreach ($orders as $order):
    $productsId = json_decode($order['products']);
    ?>
    <div class="container-fluid">

        <div class="container">
            <!-- Title -->
            <div class="d-flex justify-content-between align-items-center py-3">
                <h2 class="h5 mb-0"><a href="#" class="text-muted"></a> Order #<?= $order['id'] ?></h2>
            </div>

            <!-- Main content -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- Details -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-between">
                                <div>
                                    <span class="me-3"><?= $order['date'] ?></span>
                                </div>
                                <div class="d-flex">
                                    <a href="order.php?id=<?= $order['id'] ?>" type="button" class="btn btn-link p-0 me-3 d-none d-lg-block btn-icon-text">
                                        Go to Order</a>
                                    <div class="dropdown">
                                        <button class="btn btn-link p-0 text-muted" type="button"
                                                data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Edit</a>
                                            </li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-printer"></i>
                                                    Print</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $totalPrice = 0;
                            foreach ($productsId

                            as $id):
                            $product = selectById($conn, $id); ?>
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex mb-2">
                                            <div class="flex-shrink-0">
                                                <img src="images/<?= $product['image'] ?>" alt="" width="35"
                                                     class="img-fluid">
                                            </div>
                                            <div class="flex-lg-grow-1 ms-3">
                                                <h6 class="small mb-0"><a href="#"
                                                                          class="text-reset"><?= $product['title'] ?></a>
                                                </h6>
                                                <span class="small">Description: <?= $product['description'] ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="text-end">$ <?= $product['price'] ?></td>
                                </tr>
                                <?php $totalPrice = $totalPrice + $product['price'];
                                endforeach;
                                ?>
                                </tbody>
                                <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="2">TOTAL</td>
                                    <td class="text-end">$ <?= $totalPrice ?></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Payment -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 class="h6">Payment</h3>
                                    <p>Total: $ <?= $totalPrice ?> </p>
                                </div>
                                <div class="col-lg-6">
                                    <h3 class="h6">Comments and details</h3>
                                    <address>
                                        <strong>Name: <?= $order['name'] ?></strong><br>
                                        Comments: <?= $order['comments'] ?>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</body>
</html>
