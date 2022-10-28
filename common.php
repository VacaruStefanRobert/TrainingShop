<?php
require_once 'config.php';
function conn()
{
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}


function selectProducts($conn): array
{
    $sql = "SELECT * FROM products";
    $results = $conn->query($sql);
    $products = array();

    while ($row = $results->fetch_assoc()) {
        $products[] = $row;
    }
    return $products;
}

function selectById($conn, $id)
{
    $sql = "SELECT * FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $results = $stmt->get_result();

    return $results->fetch_assoc();
}

function removeProduct($conn, $id): void
{
    $sql = "DELETE * FROM products WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

function updateProduct($conn, $product): void
{
    $sql = "UPDATE products SET title=?, description=?, price=?,image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssdsi', $product['title'], $product['description'], $product['price'], $product['image'], $product['id']);
    $stmt->execute();
}

function addProduct($conn, $product): void
{
    $sql = "INSERT into products (title,description,price,image) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssds', $product['title'], $product['description'], $product['price'], $product['image']);
    $stmt->execute();
}

function addOrder($conn, $info): void
{
    $sql = "INSERT into orders (name,date,email,comments,price,products) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssds', $info['name'], $info['date'], $info['email'], $info['comments'], $info['price'], $info['products']);
    $stmt->execute();
}

function selectOrders($conn): array
{
    $sql = "SELECT * FROM orders";
    $results = $conn->query($sql);
    $orders = array();
    while ($row = $results->fetch_assoc()) {
        $orders[] = $row;
    }
    return $orders;
}
function selectOrdersById($conn, $id):array
{
    $sql = "SELECT * FROM orders WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $results = $stmt->get_result();

    return $results->fetch_assoc();
}

function logout($conn): void
{
    //Logout admin
    if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])) {
        unset($_SESSION['admin']);
        unset($_POST['logout']);
        header('Location: index.php');
    } elseif (isset($_POST['remove'])) {
        removeProduct($conn, $_POST['id']);
    } elseif (isset($_POST['edit'])) {
        header('Location: product.php?id=' . $_POST['id']);
    }
}

function redirectAdmin(): void
{
    //if admin redirect to his page of products
    if (isset($_SESSION['admin']) and $_SESSION['admin']) {
        header('Location: products.php');
    }
}
