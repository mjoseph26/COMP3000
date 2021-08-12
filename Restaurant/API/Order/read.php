<?php
header('Access-Control-Allow-Origin; *');
header('Content-Type: application/json');

include_once '../../Config/Database.php';
include_once '../../Models/Order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

$result = $order->read();
$num = $result->rowCount();

if($num > 0){
    $orders_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $order_item = array(
            'OrderID' => $row['OrderID'],
            'OrderTime' => $row['OrderTime'],
            'TotalPrice' => $row['TotalPrice']
        );
        array_push($orders_arr, $order_item);

    }
    echo json_encode($orders_arr);

}else{
    echo json_encode(array('message' => 'No Orders Found'));

}