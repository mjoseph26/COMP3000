<?php
session_start();
include_once('header.php');

if (!isset($_SESSION['loggedIn'])) {
    header("Location: http://localhost/Restaurant/Views/login.php");
    die();
}
?>
<html>
<head>
</head>
<body>
<div class="container" style="margin-top: 200px;">
    <h1 class="my-5 text-center">Restaurant Management Menu</h1>
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="col-md-4 my-2 mx-auto">
                <a href="orders.php" class="btn btn-info btn-block">View Orders</a>
                <a href="menu.php" class="btn btn-info btn-block">View Menu</a>
                <a href="visualisation.php" class="btn btn-info btn-block">View Statistics</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
