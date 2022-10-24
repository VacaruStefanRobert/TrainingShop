<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['cart'][]=$_POST['id'];
    require 'cart.php';
}

