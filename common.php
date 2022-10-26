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
    $sql="UPDATE products SET title=?, description=?, price=?,image=? WHERE id=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param('ssdsi',$product['title'],$product['description'],$product['price'],$product['image'],$product['id']);
    $stmt->execute();
}

function redirectAdmin(): void
{
    //if admin redirect to his page of products
    if (isset($_SESSION['admin']) and $_SESSION['admin']) {
        header('Location: products.php');
    }
}



