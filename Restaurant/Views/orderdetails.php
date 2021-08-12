<?php
include_once 'header.php';
session_start();
$curl = curl_init();
$total = 0;

if (!isset($_SESSION['loggedIn'])) {
    header("Location: http://localhost/Restaurant/Views/login.php");
    die();
}

if(isset($_POST['view_details']))
{
    $_SESSION['OrderID'] = $_POST['id'];
}

if(isset($_POST['view_items']))
{
    $_SESSION['OrderID'] = $_POST['id'];
}

$url = 'http://localhost/Restaurant/API/Order/read_orderproducts.php?OrderID=' . $_SESSION['OrderID'];
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, $url);
$response = curl_exec($curl);
$products = json_decode($response, true);

curl_close($curl);
?>
<html>
<head>

</head>
<body>
<div class="container">
    <div class="text-center">
        <h1 class="my-4">Order Details</h1>
        <table class="table my-3">
            <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($products)):
                foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <?php echo $product['ProductName'] ?>
                        </td>
                        <td>
                            <?php echo '£'.number_format($product['ProductPrice'],2) ?>
                        </td>
                        <td>
                            <?php echo $product['Quantity'] ?>
                        </td>
                        <td>
                            <?php echo ' £' . number_format($product['ProductPrice'] * (float)$product['Quantity'], 2) ?>
                        </td>
                    </tr>
                <?php endforeach;
            endif; ?>
            <tr>
                <td colspan="3" align="right">Total:</td>
                <?php
                if (isset($products)) {
                    foreach ($products as $product) {
                        $total = $total + $product['ProductPrice'] * $product['Quantity'];
                    }
                }
                echo '<td>' . number_format($total, 2) . '</td>'; ?>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>