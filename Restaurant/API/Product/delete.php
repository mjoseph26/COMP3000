<?php


header('Access-Control-Allow-Origin; *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,X-Requested-With');

include_once '../../Config/Database.php';
include_once '../../Models/Product.php';

$database = new Database();
$db = $database->connect();

$product = new Product($db);
$product->productId = isset($_GET['ProductID']) ? $_GET['ProductID'] : die();


if ($product->delete()) {
    echo json_encode(array('message' => 'Product Deleted'));
} else {
    echo json_encode(array('message' => 'Product Not Deleted'));
}
