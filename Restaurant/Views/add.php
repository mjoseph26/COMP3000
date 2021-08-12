<?php
include_once('header.php');


if (isset($_POST['addProduct'])) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://localhost/Restaurant/API/Product/create.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = array('ProductName' => $_POST['name'], 'ProductDescription' => $_POST['description'], 'ProductPrice' => $_POST['price']);
    $data_string = json_encode($data);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
    );
    $result = curl_exec($curl);
    $error = curl_error($curl);
    header('Location:menu.php');
}

?>
<html>
<head></head>
<body>
<div class="container" style="margin-top: 100px;">
    <h1 class="my-5 text-center">Add New Product</h1>
    <div class="row justify-content-center">
        <div class="col-md-8 text-center border">
            <form method="post" action="add.php" class="my-3">
                <div class="form-group">
                    <label>Product Name:</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Name of Product" required>
                </div>
                <div class="form-group">
                    <label>Product Description: </label>
                    <textarea class="form-control" rows="3" placeholder="Enter Description of Product"
                              name="description"></textarea>
                </div>
                <div class="form-group">
                    <label>Product Price:</label>
                    <input type="number" min="0" step=".01" class="form-control"
                           value="<?php echo $result['ProductPrice'] ?>" name="price"
                           placeholder="Enter Cost of Product" required>
                </div>
                <button type="submit" class="btn btn-primary my-3" name="addProduct">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
