<?php
class Order {
    private $connection;
    public $orderId;
    public $orderTime;
    public $orderPrice;
    public $products = array();
    public $dailyOrders = array();
    public $productQuantities = array();
    public $salesQuantities = array();

    public function __construct($db){
        $this->connection = $db;
    }

    //Read Orders
    public function read() {
        $query = 'SELECT * FROM ORDERS ORDER BY OrderTime DESC';
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }

    public function read_single(){
        $query = 'SELECT * FROM ORDERS WHERE OrderID = ?';
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $this->orderId);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->orderId = $result['OrderID'];
        $this->orderTime = $result['OrderTime'];
        $this->orderPrice = $result['TotalPrice'];
    }

    public function addOrderInfo()
    {
        $query = 'INSERT INTO ORDER_PRODUCT(OrderID, ProductID, Quantity) VALUES(:orderId,:product,:quantity)';
        $statement = $this->connection->prepare($query);
        $this->orderId = htmlspecialchars(strip_tags($this->orderId));
        $statement->bindParam(':orderId',$this->orderId);
        $this->productQuantities[0] = htmlspecialchars(strip_tags($this->productQuantities[0]));
        $statement->bindParam(':product',$this->productQuantities[0]);
        $this->productQuantities[1] = htmlspecialchars(strip_tags($this->productQuantities[1]));
        $statement->bindParam(':quantity',$this->productQuantities[1]);

        if($statement->execute())
        {
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function create(){
        $query = 'INSERT INTO ORDERS(TotalPrice)
        VALUES(:price)';
        $statement = $this->connection->prepare($query);
        $this->orderPrice = htmlspecialchars(strip_tags($this->orderPrice));
        $statement->bindParam(':price',$this->orderPrice);

        if($statement->execute())
        {
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;

    }

    public function update(){
        $query = 'UPDATE ORDERS
        SET OrderTime = :time, TotalPrice = :price WHERE OrderID =:id';
        $statement = $this->connection->prepare($query);
        $this->orderId = htmlspecialchars(strip_tags($this->orderId));
        $this->orderTime = htmlspecialchars(strip_tags($this->orderTime));
        $this->orderPrice = htmlspecialchars(strip_tags($this->orderPrice));

        $statement->bindParam(':id', $this->orderId);
        $statement->bindParam(':time',$this->orderTime);
        $statement->bindParam(':price',$this->orderPrice);

        if($statement->execute())
        {
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;

    }

    public function delete(){
        $query = 'DELETE FROM ORDERS WHERE OrderID =:id';
        $statement = $this->connection->prepare($query);
        $this->orderId = htmlspecialchars(strip_tags($this->orderId));

        $statement->bindParam(':id',$this->orderId);

        if($statement->execute())
        {
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;


    }

    public function getOrderProducts()
    {
        $query = 'SELECT Product.ProductName, Product.ProductID, Product.ProductPrice, Order_Product.Quantity FROM Order_Product,Product,Orders WHERE 
        Orders.OrderID = :id AND Orders.OrderID = Order_Product.OrderID AND Order_Product.ProductID = Product.ProductID';
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $this->orderId);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $product_list = array(
                'ProductID' => $row['ProductID'],
                'ProductName' => $row['ProductName'],
                'ProductPrice' => $row['ProductPrice'],
                'Quantity' => $row['Quantity']
            );
            $this->products[] = $product_list;
        }
    }

    public function getMostRecentOrder()
    {
        $query = 'SELECT OrderID FROM Orders ORDER BY OrderID DESC LIMIT 1';
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->orderId = $result['OrderID'];
    }

    public function getDailyRevenue()
    {
        $query = 'SELECT DISTINCT CAST(OrderTime AS DATE) AS "OrderTime",SUM(TotalPrice) AS "TotalPrice"
        FROM Orders GROUP BY CAST(OrderTime AS DATE) ORDER BY CAST(OrderTime AS DATE) DESC LIMIT 7';



        $statement = $this->connection->prepare($query);
        $statement->execute();

        while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $order_list = array(
                'OrderTime' => $row['OrderTime'],
                'TotalPrice' => $row['TotalPrice']
            );
            $this->dailyOrders[] = $order_list;
        }

    }

    public function getSalesQuantities()
    {
        $query = 'SELECT DISTINCT SUM(Quantity),Product.ProductName FROM Product,Order_Product WHERE Order_Product.ProductID = Product.ProductID GROUP BY Product.ProductName';
        $statement = $this->connection->prepare($query);
        $statement->execute();

        while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $sold_quantities = array(
                'ProductName' => $row['ProductName'],
                'Quantity' => $row['SUM(Quantity)']
            );
            $this->salesQuantities[] = $sold_quantities;
        }


    }

    public function getOrderByDate()
    {
        $query = 'SELECT * FROM Orders WHERE CAST(OrderTime AS DATE) = :timeoforder';
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':timeoforder', $this->orderTime);
        $statement->execute();
        return $statement;
    }

}