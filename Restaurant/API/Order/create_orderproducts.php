<?php

header('Access-Control-Allow-Origin; *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,X-Requested-With');

include_once '../../Config/Database.php';
include_once '../../Models/Order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

$data = json_decode(file_get_contents("php://input"));
$order->orderId = $data->OrderID;
$order->productQuantities[0] = $data->ProductID;
$order->productQuantities[1] = $data->Quantity;


if ($order->addOrderInfo()) {
    echo json_encode(array('message' => 'Order-Product Information Created'));
} else {
    echo json_encode(array('message' => 'Order-Product Information Not Created'));
}