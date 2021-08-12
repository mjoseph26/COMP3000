<?php
include_once 'header.php';
session_start();
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://localhost/Restaurant/API/Order/read.php');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
$output = json_decode($result, true);

if (!isset($_SESSION['loggedIn'])) {
    header("Location: http://localhost/Restaurant/Views/login.php");
    die();
}



?>

<html>
<head>

</head>
<div class="container">
    <div class="text-center">
        <h1 class="mt-4">List Of Orders</h1>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-10 border my-3 text-center">
            <form class="my-2" method="post" action="search.php">
                <h1>Search for an Order</h1>
                <div class="form-group mt-4">
                    <label>Date of Order: </label>
                    <input type="date" placeholder="Enter Date" name="date">
                </div>

                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <div class="text-center">
        <?php foreach ($output as $out): ?>
        <form class="text-center my-4" method="post" action="orderdetails.php">
            <h3><?php $date = strtotime($out['OrderTime']);
                echo date('d/m/Y H:i', $date); ?></h3>
            <h3><?php echo 'Total: £' . $out['TotalPrice']; ?></h3>
            <input type="hidden" value="<?php echo $out['OrderID'] ?>" name="id"/>
            <button type="submit" name="view_details" class="btn btn-info">View Details</button>
        </form>
    </div>
    <?php endforeach; ?>


</div>


</body>
</html>
