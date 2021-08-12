<?php
include_once 'header.php';
session_start();

if (!isset($_SESSION['order'])) {
    header("Location: http://localhost/Restaurant/Views/homepage.php");
    die();
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://localhost/Restaurant/API/Order/create.php');

if (isset($_SESSION['total'])) {
    $data = array('TotalPrice' => $_SESSION['total']);
    $data_string = json_encode($data);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
    );
    $result = curl_exec($curl);
    $error = curl_error($curl);
}

//var_dump($result);

curl_close($curl);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://localhost/Restaurant/API/Order/getRecentOrder.php');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
$output = json_decode($result, true);
$latestOrderID = $output['OrderID'];

curl_close($curl);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://localhost/Restaurant/API/Order/create_orderproducts.php');
if (isset($_SESSION['order'])) {
    foreach ($_SESSION['order'] as $key => $value) {
        $data = array('OrderID' => $latestOrderID, 'ProductID' => $value['id'], 'Quantity' => $value['quantity']);
        $data_string = json_encode($data);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($curl);
        $error = curl_error($curl);
    }
}


curl_close($curl);


//var_dump($result);


?>
    <html>
    <head>
    </head>

    <body>
    <div class="container text-center mx-auto">
        <div class="row">
            <div class="col-md-10 mx-auto border" style="margin-top: 250px;">
                <h1>Thank you, your order has been placed</h1>
                <h2>Order Total:<?php if (isset($_SESSION['total'])) {
                        echo ' £' . number_format($_SESSION['total'], 2);
                    } ?></h2>

                <h2>Order ID: <?php if (isset($latestOrderID)) {
                        echo $latestOrderID;
                    } ?></h2>

            </div>
        </div>
    </div>


    </body>
    </html>
<?php session_unset(); ?>