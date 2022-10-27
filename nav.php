<?php if(isset($_SESSION['admin']) and $_SESSION['admin']):?>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="products.php">Products</a>
                    <a class="nav-link active" aria-current="page" href="orders.php">Orders</a>
                    <form id="logout1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <button onclick="logout()" class=" btn btn-outline-light nav-link active" aria-current="page" name="logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <script>
      function logout() {
        document.getElementById("logout1").submit();
      }
    </script>
<?php else:?>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="index.php">Products</a>
                <a class="nav-link" href="login.php">Login</a>
                <a class="nav-link" href="cart.php">Cart</a>
            </div>
        </div>
    </div>
</nav>
<?php endif;