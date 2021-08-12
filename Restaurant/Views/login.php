<?php
include_once('header.php');
session_start();
$incorrect = false;
$user = 'admin';
$pass = sha1('staffpass');
if (isset($_SESSION['loggedIn'])) {
    header("Location: http://localhost/Restaurant/Views/staffhomepage.php");
    die();

}

if (isset($_POST['login'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        if ($_POST['username'] == $user && sha1($_POST['password']) == $pass) {
            $_SESSION['loggedIn'] = true;
            echo "<script>window.location ='staffhomepage.php';</script>";
        } else {
            $incorrect = true;
        }
    }
}

?>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container" style="margin-top: 200px;">
    <h1 class="my-5 text-center">Management Login</h1>
    <div class="row justify-content-center">
        <div class="col-md-8 text-center border">
            <form method="post" action="login.php" class="my-3">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary my-3" name="login">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php if ($incorrect == true) {
    echo '<div class="col-sm-10 mx-auto text-center"><div class="alert alert-danger" role="alert">Incorrect Login Credentials</div></div>';
} ?>
</body>
</html>
