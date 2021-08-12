<?php


header('Access-Control-Allow-Origin; *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,X-Requested-With');

include_once '../../Config/Database.php';
include_once '../../Models/Product.php';

$database = new Database();
$db = $database->connect();

$product = new Product($db);
$product->productId = isset($_GET['ProductID']) ? $_GET['ProductID'] : die();//to get data from url

$data = json_decode(file_get_contents("php://input"));//to get data from body

//$order->orderId = $data->OrderID;

$product->productName = $data->ProductName;
$product->productDescription = $data->ProductDescription;
$product->productPrice = $data->ProductPrice;


if ($product->update()) {
    echo json_encode(array('message' => 'Product Updated'));
} else {
    echo json_encode(array('message' => 'Product Not Updated'));
}