<?php

header('Access-Control-Allow-Origin; *');
header('Content-Type: application/json');

include_once '../../Config/Database.php';
include_once '../../Models/Order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

$order->orderId = isset($_GET['OrderID']) ? $_GET['OrderID'] : die();

$order->read_single();

$order_arr = array(
    'OrderID' => $order->orderId,
    'OrderTime' => $order->orderTime,
    'OrderPrice' => $order->orderPrice
);

print_r(json_encode($order_arr));
