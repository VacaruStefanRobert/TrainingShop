<?php

session_start();
require_once 'config.php';
require_once 'languages.php';

function conn(): ?PDO
{
    try {
        $conn = new PDO('mysql:host=' . SERVERNAME . ';dbname=' . DBNAME, USERNAME, PASSWORD);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException) {
        die('Connection failed!');
    }
}

function selectProducts($conn): array
{
    $sql = 'SELECT * FROM products';
    $results = $conn->query($sql);
    return $results->fetchAll();
}

function checkPrivileges()
{
    if (!isset($_SESSION['admin'])) {
        header('Location: index.php');
        exit();
    }
}

function translate($word)
{
    $lang = [];
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        // break up string into pieces (languages and q factors)
        preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang);

        if ($lang[1][1] == 'en') {
            if (isset($GLOBALS['ro'][$word])) {
                return $GLOBALS['ro'][$word];
            }
        }
    }
    return $word;
}

function validateProduct($product)
{
    foreach ($product as $field) {
        if (empty($field)) {
            header('Location: product.php?error=Empty fields!');
            exit;
        }
    }
    $target_dir = 'images/';
    $target_file = $target_dir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST['submit'])) {
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            header('Location: product.php?error=File is not an image.');
            exit;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        header('Location: product.php?error=Sorry, file already exists.');
        exit;
    }
    // Check file size
    if ($_FILES['image']['size'] > 500000) {
        header('Location: product.php?error=Sorry, your file is too large.');
        exit;
    }
    // Allow certain file formats
    if ($imageFileType !== 'jpg' && $imageFileType !== 'png' && $imageFileType !== 'jpeg'
        && $imageFileType !== 'gif' && $imageFileType !== 'jfif') {
        header('Location: product.php?error=Sorry, only JPG, JPEG, PNG, JFIF & GIF files are allowed.');
        exit;
    }
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        header('Location: product.php?error=Sorry, there was an error uploading your file.');
        exit;
    }

}

function deleteImageFromStorage($image)
{
    $file_pointer = 'images/' . $image;
    // Use unlink() function to delete a file
    if (!unlink($file_pointer)) {
        header('Location: products.php?error=' . $file_pointer . 'cannot be deleted due to an error');
        exit;
    }
}

function validateForm($info)
{
    foreach ($info as $field) {
        if (empty($field)) {
            header('Location: cart.php?error=Empty fields!');
            exit;
        }
    }
    if (!preg_match("/^[a-zA-Z-' ]*$/", $info[0])) {
        header('Location: cart.php?errorName=Only letters and white space allowed');
        exit;
    }
    if (!filter_var($info[2], FILTER_VALIDATE_EMAIL)) {
        header('Location: cart.php?errorMail=Invalid email format');
        exit;
    }
}
