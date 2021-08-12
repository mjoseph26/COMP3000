<?php
session_start();
session_destroy();
header("Location: http://localhost/Restaurant/Views/login.php");
?>