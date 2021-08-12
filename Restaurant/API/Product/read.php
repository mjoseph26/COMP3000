<?php
header('Access-Control-Allow-Origin; *');
header('Content-Type: application/json');

include_once '../../Config/Database.php';
include_once '../../Models/Product.php';

$database = new Database();
$db = $database->connect();

$product = new Product($db);

$result = $product->read();
$num = $result->rowCount();

if($num > 0){
    $products_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        $product_item = array(
            'ProductID' => $row['ProductID'],
            'ProductName' => $row['ProductName'],
            'ProductDescription' => $row['ProductDescription'],
            'ProductPrice' => $row['ProductPrice']

        );
        array_push($products_arr, $product_item);

    }
    echo json_encode($products_arr);

}else{
    echo json_encode(array('message' => 'No Products Found'));

}