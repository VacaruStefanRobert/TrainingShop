<?php
require_once 'config.php';
if (!isset($_SESSION)) {
    session_start();
    $_SESSION['cart']=array();
}
function conn()
{
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

$conn = conn();

function selectProducts($conn)
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


    $product = $results->fetch_assoc();
    return $product;
}



