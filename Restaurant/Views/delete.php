<?php

if(isset($_GET['action']))
{
    if($_GET['action'] == 'delete')
    {
        $curl  = curl_init();
        $productID = $_GET['id'];
        $url = 'http://localhost/Restaurant/API/Product/delete.php?ProductID='.$productID;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        header('Location:menu.php');
    }


}
