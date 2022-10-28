<?php

require_once 'config.php';
function conn(): ?PDO
{
    try {
        $conn = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DBNAME, USERNAME, PASSWORD);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return null;
}


function selectProducts($conn): array
{
    $sql = 'SELECT * FROM products';
    $results = $conn->query($sql);
    $products = array();

    while ($row = $results->fetch()) {
        $products[] = $row;
    }
    return $products;
}

function selectById($conn, $id)
{
    $sql = 'SELECT * FROM products WHERE id =:id';
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();

}

function removeProduct($conn, $id): void
{
    $sql = 'DELETE FROM products WHERE id=?';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
}

function updateProduct($conn, $product): void
{
    $sql = 'UPDATE products SET title=?, description=?, price=?,image=? WHERE id=?';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $product['title'], PDO::PARAM_STR);
    $stmt->bindParam(2, $product['description'], PDO::PARAM_STR);
    $stmt->bindParam(3, $product['price'], PDO::PARAM_INT);
    $stmt->bindParam(4, $product['image'], PDO::PARAM_STR);
    $stmt->bindParam(5, $product['id'], PDO::PARAM_INT);
    $stmt->execute();
}

function addProduct($conn, $product): void
{
    $sql = 'INSERT into products (title,description,price,image) VALUES (?,?,?,?)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $product['title'], PDO::PARAM_STR);
    $stmt->bindParam(2, $product['description'], PDO::PARAM_STR);
    $stmt->bindParam(3, $product['price'], PDO::PARAM_INT);
    $stmt->bindParam(4, $product['image'], PDO::PARAM_STR);
    $stmt->execute();
}

function addOrder($conn, $info): void
{
    $sql = 'INSERT into orders (name,date,email,comments,price,products) VALUES (?,?,?,?,?,?)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $info['name'], PDO::PARAM_STR);
    $stmt->bindParam(2, $info['date'], PDO::PARAM_STR);
    $stmt->bindParam(3, $info['email'], PDO::PARAM_INT);
    $stmt->bindParam(4, $info['comments'], PDO::PARAM_STR);
    $stmt->bindParam(5, $info['price'], PDO::PARAM_STR);
    $stmt->bindParam(6, $info['products'], PDO::PARAM_STR);
    $stmt->execute();
}

function selectOrders($conn): array
{
    $sql = 'SELECT * FROM orders';
    $results = $conn->query($sql);
    $orders = array();
    while ($row = $results->fetch()) {
        $orders[] = $row;
    }
    return $orders;
}

function selectOrdersById($conn, $id): array
{
    $sql = 'SELECT * FROM orders WHERE id=:id';
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

function logout($conn): void
{
    //Logout admin
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['logout'])) {
        unset($_SESSION['admin']);
        unset($_POST['logout']);
        header('Location: index.php');
    } elseif (isset($_POST['remove'])) {
        removeProduct($conn, $_POST['id']);
    } elseif (isset($_POST['edit'])) {
        header('Location: product.php?id=' . $_POST['id']);
        exit();
    }
}

function redirectAdmin(): void
{
    //if admin redirect to his page of products
    if (isset($_SESSION['admin']) and $_SESSION['admin']) {
        header('Location: products.php');
        exit();
    }
}
