<?php

require_once 'common.php';

$conn = conn();
//logout admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['logout'])) {
    unset($_SESSION['admin']);
    header('Location: index.php');
    exit;
}
//login admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['name']) && !empty($_POST['password'])) {
        $name = strip_tags($_POST['name']);
        $password = strip_tags($_POST['password']);
        if ($name !== ADMINNAME || $password !== ADMINPASS) {
            $error = 'Wrong Credentials!';
        } else {
            $_SESSION['admin'] = true;
            header('Location: products.php');
            exit;
        }
    } else {
        $error = 'Some fields are empty!';
    }
}
require_once 'head.php'; ?>
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-primary text-white">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">
                            <form method="POST">
                                <h2 class="fw-bold mb-2 text-uppercase"><?= translate('Login') ?></h2>
                                <p class="text-white-50 mb-5"><?= translate('Please enter your username and password!') ?></p>
                                <p class="text-50 mb-5" style="color: red"><?= $error ?? '' ?></p>
                                <div class="form-outline form-white mb-4">
                                    <label class="form-label" for="typeNameX"><?= translate('Username') ?></label>
                                    <input type="text" id="typeNameX" class="form-control form-control-lg" name="name"/>

                                </div>
                                <div class="form-outline form-white mb-4">
                                    <label class="form-label" for="typePasswordX"><?= translate('Password') ?></label>
                                    <input type="password" id="typePasswordX" class="form-control form-control-lg"
                                           name="password"/>
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5"
                                        type="submit"><?= translate('Login') ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
