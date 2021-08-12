<?php

header('Access-Control-Allow-Origin; *');
header('Content-Type: application/json');

include_once '../../Config/Database.php';
include_once '../../Models/Product.php';

$database = new Database();
$db = $database->connect();

$product = new Product($db);

$product->productId = isset($_GET['ProductID']) ? $_GET['ProductID'] : die();

$product->read_single();

$product_arr = array(
    'ProductID' => $product->productId,
    'ProductName' => $product->productName,
    'ProductDescription' => $product->productDescription,
    'ProductPrice' => $product->productPrice
);

print_r(json_encode($product_arr));

