<?php
session_start();
include_once('header.php');



if(isset($_GET['action'])){
    if($_GET['action'] == 'edit')
    {
        $curl = curl_init();
        $url = 'http://localhost/Restaurant/API/Product/read_single.php?ProductID='.$_GET['id'];
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        $response = curl_exec($curl);
        $result = json_decode($response, true);
        curl_close($curl);

    }
}

if(isset($_POST['editProduct'])){
        $curl = curl_init();
        $url = 'http://localhost/Restaurant/API/Product/update.php?ProductID='.$_POST['productID'];
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = array('ProductName' => $_POST['name'], 'ProductDescription' => $_POST['description'], 'ProductPrice' => $_POST['price']);
        $data_string = json_encode($data);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
    );
        $response = curl_exec($curl);

    header('Location:menu.php');

}
?>

<html>
<head></head>
<body>
<div class="container" style="margin-top: 100px;">
    <h1 class="my-5 text-center">Edit Product Details</h1>
    <div class="row justify-content-center">
        <div class="col-md-8 text-center border">
            <form method="post" action="edit.php" class="my-3">
                <?php if(isset($result)): ?>
                <div class="form-group">
                    <label>Product Name:</label>
                    <input type="text" class="form-control" value="<?php echo $result['ProductName']?>" name="name" placeholder="Enter Name of Product" required>
                </div>
                <div class="form-group">
                    <label>Product Description:</label>
                    <input type="text" class="form-control" value="<?php echo $result['ProductDescription']?>" name="description" placeholder="Enter Description of Product">
                </div>
                <div class="form-group">
                    <label>Product Price:</label>
                    <input type="number"  min="0" step=".01" class="form-control" value="<?php echo $result['ProductPrice']?>" name="price" placeholder="Enter Cost of Product" required>
                </div>
                    <input type="hidden" class="form-control" value="<?php if(isset($_GET['action'])){
                        if($_GET['action'] == 'edit'){
                            echo $_GET['id'];
                        }
                    }
                    ?>" name="productID" required>
                <button type="submit" class="btn btn-primary my-3" name="editProduct">Submit</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>
