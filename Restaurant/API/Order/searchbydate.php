<?php


header('Access-Control-Allow-Origin; *');
header('Content-Type: application/json');

include_once '../../Config/Database.php';
include_once '../../Models/Order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

$data = json_decode(file_get_contents("php://input"));
$order->orderTime = $data->OrderTime;

$result = $order->getOrderByDate();
$num_row = $result->rowCount();

if($num_row > 0){
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