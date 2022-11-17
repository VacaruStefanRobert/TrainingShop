<?php

require_once 'common.php';

$conn = conn();
//verifying if u have privileges
checkPrivileges();
$sql = 'SELECT * FROM orders';
$results = $conn->query($sql);
$orders = $results->fetchAll();

require_once 'head.php';
foreach ($orders as $order):?>
    <div class="container-fluid">

        <div class="container">
            <!-- Title -->
            <div class="d-flex justify-content-between align-items-center py-3">
                <h2 class="h5 mb-0"><a href="#" class="text-muted"></a> <?= translate('Order') ?> #<?= $order['id'] ?>
                </h2>
            </div>

            <!-- Main content -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- Details -->
                    <!-- Payment -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-between">
                                <div>
                                    <span class="me-3"><?= $order['date'] ?></span>
                                </div>
                                <div class="d-flex">
                                    <a href="order.php?id=<?= $order['id'] ?>" type="button"
                                       class="btn btn-link p-0 me-3 d-none d-lg-block btn-icon-text">
                                        <?= translate('Go to Order') ?></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 class="h6"><?= translate('Payment') ?></h3>
                                    <p>Total: $ <?= $order['price'] ?> </p>
                                </div>
                                <div class="col-lg-6">
                                    <h3 class="h6"><?= translate('Comments and details') ?></h3>
                                    <address>
                                        <strong><?= translate('Name') ?>: <?= $order['name'] ?></strong><br>
                                        <?= translate('Comments and details') ?>: <?= $order['comments'] ?>
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
