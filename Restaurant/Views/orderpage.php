<?php
include_once 'header.php';
session_start();
$total = 0;
$itemExists = false;
$displayMessage = 0;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://localhost/Restaurant/API/Product/read.php');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
$output = json_decode($result, true);


if (isset($_POST['order'])) {
    if(isset($_SESSION['order']))
    {
        foreach ($_SESSION['order'] as $key => $value) {
            if ($value['id'] == $_POST['product_id']) {
                $itemExists = true;
            }
        }
    }

    if ($itemExists == true) {
        $displayMessage = 1;

    } else {
        if (isset($_SESSION['order'])) {
            $order_item = array(
                'id' => $_POST['product_id'],
                'name' => $_POST['product_name'],
                'quantity' => $_POST['quantity'],
                'price' => $_POST['product_price']);
            $_SESSION['order'][] = $order_item;
        } else {
            $order_item = array(
                'id' => $_POST['product_id'],
                'name' => $_POST['product_name'],
                'quantity' => $_POST['quantity'],
                'price' => $_POST['product_price']);
            $_SESSION['order'][0] = $order_item;
        }
    }


}


if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION['order'] as $key => $value) {
            if ($value['id'] == $_GET['id'])// find the item with the specific id if the delete id matches an item in the sessions array remove it using unset
            {
                unset($_SESSION['order'][$key]);
                echo '<script>window.location="orderpage.php"</script>';
            }
        }
    }
}

?>



<div class="container text-center mx-auto" >
    <div class="row">
        <?php foreach ($output as $out): ?>
            <div class="col mx-3 my-5 border">
                <form method="post" action="orderpage.php" class="my-2">
                    <h3><?php echo $out['ProductName'] ?></h3>
                    <h5><?php echo $out['ProductDescription'] ?></h5>
                    <h5><?php echo ' £'.number_format($out['ProductPrice'],2) ?></h5>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Quantity</label>
                        <input type="number" name="quantity" min="1" step="1" oninput="validity.valid||(value='');"
                               required/>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo $out['ProductID'] ?>"/>
                    <input type="hidden" name="product_name" value="<?php echo $out['ProductName'] ?>"/>
                    <input type="hidden" name="product_price" value="<?php echo $out['ProductPrice'] ?>"/>
                    <button type="submit" class="btn btn-info my-3" name="order">Add to Order</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    if ($displayMessage== 1) {
    echo '<div class="col-sm-10 mx-auto"><div class="alert alert-danger" role="alert">Product is already included in the order</div></div>';
    }?>
    <div class="mx-auto mt-5 mb-2">
        <h3>Order Summary</h3>
    </div>
    <table class="table my-3">
        <thead>
        <tr>
            <th scope="col">Product</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tr>
            <?php if(isset($_SESSION['order'])):
            foreach ($_SESSION['order'] as $key => $value): ?>
        <tr>
            <td><?php if (isset($value['name'])) {
                    echo $value['name'];
                } ?></td>
            <td><?php if (isset($value['price'])) {
                    echo ' £'.number_format($value['price'],2);
                } ?></td>
            <td><?php if (isset($value['quantity'])) {
                    echo $value['quantity'];
                } ?></td>
            <td><?php echo ' £'.number_format($value['price'] * (float)$value['quantity'], 2) ?></td>
            <td>
                <a href="orderpage.php?action=delete&id=<?php if (isset($value['id'])) {
                    echo $value['id'];
                } ?>"><span
                            class="text-danger">Remove</span></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        <tr>
            <td colspan="3" align="right">Total:</td><?php
            if(isset($_SESSION['order'])) {
                foreach ($_SESSION['order'] as $key => $value) {
                    $total = $total + $value['price'] * $value['quantity'];
                    $_SESSION['total'] = $total;
                }
            }
            echo '<td>' . number_format($total, 2) . '</td>'; ?>
        </tr>
        </tbody>
    </table>
    <div class="mx-auto mt-3 mb-3 ">
        <form method="post" action="cart.php">
            <input type="hidden" value="<?php number_format($total, 2) ?>" name="total"/>
            <button class="btn btn-success" type="submit">Proceed To Checkout</button>
        </form>

    </div>

</div>
</body>


</html>
