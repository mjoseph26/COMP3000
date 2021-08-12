<?php
include_once('header.php');

session_start();
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://localhost/Restaurant/API/Product/read.php');
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
<body>
<div class="container">
    <div class="text-center">
        <h1 class="my-4">Restaurant Menu</h1>
        <a href="add.php" class="btn btn-primary">Add Product</a>
        <table class="table my-3">
            <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($output)):
                foreach ($output as $out): ?>
                    <tr>
                        <td>
                            <?php echo $out['ProductName'] ?>
                        </td>
                        <td>
                            <?php echo $out['ProductDescription'] ?>
                        </td>
                        <td>
                            <?php echo '£'. number_format($out['ProductPrice'],2) ?>
                        </td>
                        <td>
                            <a href="edit.php?action=edit&id=<?php if(isset($out['ProductID']))
                            {
                                echo $out['ProductID'];
                            }?>" class="btn btn-primary">Edit</a>
                            <a href="delete.php?action=delete&id=<?php if(isset($out['ProductID']))
                            {
                                echo $out['ProductID'];
                            }?>" class="btn btn-danger">Delete</a>

                        </td>
                    </tr>
                <?php endforeach;
            endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
