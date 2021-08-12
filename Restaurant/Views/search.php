<?php
include_once 'header.php';
session_start();
$curl = curl_init();
$total = 0;
$noResults = false;
curl_setopt($curl, CURLOPT_URL, 'http://localhost/Restaurant/API/Order/searchbydate.php');

if (!isset($_SESSION['loggedIn'])) {
    header("Location: http://localhost/Restaurant/Views/login.php");
    die();
}

if (isset($_POST['date'])) {
    $date = strtotime($_POST['date']);
    $formattedDate = date('Y/m/d', $date);
    $data = array('OrderTime' => $formattedDate);
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
    $output = json_decode($result, true);
}

curl_close($curl);

foreach($output as $out)
{
    if(!isset($out['TotalPrice']))
    {
        $noResults = true;
    }
}

?>
<html>
<head>
</head>
<body>

<div class="container">
    <div class="text-center">
        <h1 class="my-3">List of Orders</h1>
        <?php
            if($noResults == true)
            {
                if (isset($_POST['date'])) {
                    $date = strtotime($_POST['date']);
                    $formattedDate = date('d/m/Y', $date);
                    echo '<h3 class="my-3">'.$formattedDate.'</h3>';
                }
                echo '<div class="col-sm-10 mx-auto my-5"><div class="alert alert-danger" role="alert">No Orders Available</div></div>';
            }
        ?>
        <?php
        if (isset($output)):
        foreach ($output as $out):
        if(isset($out['TotalPrice'])):?>
        <form class="text-center my-3" method="post" action="orderdetails.php">
            <h3><?php if(isset($out['OrderTime']))
                {
                    $date = strtotime($out['OrderTime']);
                }
                echo date('d/m/Y H:i', $date); ?></h3>
            <h3><?php if(isset($out['TotalPrice']))
                {
                    echo 'Total: £' . $out['TotalPrice'];
                }?></h3>

            <input type="hidden" name='id' value="<?php echo $out['OrderID'] ?>"/>
            <button type="submit" class="btn btn-info" name="view_items">View Details</button>
        </form>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>

