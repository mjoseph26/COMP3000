<?php
header('Access-Control-Allow-Origin; *');
header('Content-Type: application/json');

include_once '../../Config/Database.php';
include_once '../../Models/Order.php';


$database = new Database();
$db = $database->connect();

$order = new Order($db);

$order->getSalesQuantities();

print_r(json_encode($order->salesQuantities));
