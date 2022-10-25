<?php
session_start();
require_once 'common.php';
$conn=conn();

//verifying if u have privileges
if (isset($_SESSION['admin']) and $_SESSION['admin']) {
    $product = selectById($conn,$_GET['id']);
} else {
    header('Location: index.php');
}
