<?php

header('Access-Control-Allow-Origin; *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,X-Requested-With');

include_once '../../Config/Database.php';
include_once '../../Models/Order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);
$order->orderId = isset($_GET['OrderID']) ? $_GET['OrderID'] : die();//to get data from url

$data = json_decode(file_get_contents("php://input"));//to get data from body

//$order->orderId = $data->OrderID;

$order->orderTime = $data->OrderTime;
$order->orderPrice = $data->TotalPrice;


if ($order->update()) {
    echo json_encode(array('message' => 'Order Updated'));
} else {
    echo json_encode(array('message' => 'Order Not Updated'));
}