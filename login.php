<?php
session_start();
require_once 'common.php';
//login admin
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];
    if ($name != ADMINNAME) {
        echo '<script>alert("Incorrect username");</script>';
    } elseif ($password != ADMINPASS) {
        echo '<script>alert("Incorrect password");</script>';
    } else {
        $_SESSION['admin'] = true;
        header('Location: products.php');
    }
}
?>
<html lang="EN">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Login Form</h1>
<div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <ul class="flex-outer">
            <li>
                <label for="name">First Name</label>
                <input type="text" id="name" placeholder="Enter your first name here" name="name">
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Enter your password here" name="password">
            </li>
            <li>
                <button type="submit">Submit</button>
            </li>
        </ul>
    </form>
</div>
<a href="index.php">Go to Shop!</a>
</body>
</html>
