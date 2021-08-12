<?php

header('Access-Control-Allow-Origin; *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,X-Requested-With');

include_once '../../Config/Database.php';
include_once '../../Models/Order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);
$order->orderId = isset($_GET['OrderID']) ? $_GET['OrderID'] : die();

/*$data = json_decode(file_get_contents("php://input"));

$order->orderId = $data->OrderID;*/


if ($order->delete()) {
    echo json_encode(array('message' => 'Order Deleted'));
} else {
    echo json_encode(array('message' => 'Order Not Deleted'));
}
