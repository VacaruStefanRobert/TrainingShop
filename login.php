<?php

session_start();
require_once 'common.php';
//login admin
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST['name']) and !empty($_POST['password'])) {
        $name = strip_tags($_POST['name']);
        $password = strip_tags($_POST['password']);
        if ($name != ADMINNAME) {
            echo '<script>alert("Incorrect username");</script>';
        } elseif ($password != ADMINPASS) {
            echo '<script>alert("Incorrect password");</script>';
        } else {
            $_SESSION['admin'] = true;
            header('Location: products.php');
            exit();
        }
    } else {
        echo '<script>alert("Some fields are empty!");</script>';
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
                            <form action="" method="POST">
                                <h2 class="fw-bold mb-2 text-uppercase"><?= translate('Login') ?></h2>
                                <p class="text-white-50 mb-5"><?= translate('Please enter your username and password!') ?></p>

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
