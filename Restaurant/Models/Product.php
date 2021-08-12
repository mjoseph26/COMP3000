<?php
Class Product{

    private $connection;
    public $productId;
    public $productName;
    public $productDescription;
    public $productPrice;

    public function __construct($db){
        $this->connection = $db;
    }




    public function read() {
        $query = 'SELECT * FROM PRODUCT';
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }

    public function read_single(){
        $query = 'SELECT * FROM PRODUCT WHERE ProductID = ?';
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $this->productId);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->productID = $result['ProductID'];
        $this->productName = $result['ProductName'];
        $this->productDescription = $result['ProductDescription'];
        $this->productPrice = $result['ProductPrice'];
    }

    public function create(){
        $query = 'INSERT INTO PRODUCT(ProductName,ProductDescription,ProductPrice)
        VALUES(:name,:description,:price)';
        $statement = $this->connection->prepare($query);
        $this->productName = htmlspecialchars(strip_tags($this->productName));
        $this->productDescription = htmlspecialchars(strip_tags($this->productDescription));
        $this->productPrice = htmlspecialchars(strip_tags($this->productPrice));

        $statement->bindParam(':name',$this->productName);
        $statement->bindParam(':description',$this->productDescription);
        $statement->bindParam(':price',$this->productPrice);

        if($statement->execute())
        {
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;

    }

    public function update(){
        $query = 'UPDATE PRODUCT
        SET ProductName = :name, ProductDescription = :description, ProductPrice = :price WHERE ProductID =:id';
        $statement = $this->connection->prepare($query);
        $this->productId = htmlspecialchars(strip_tags($this->productId));
        $this->productName = htmlspecialchars(strip_tags($this->productName));
        $this->productDescription = htmlspecialchars(strip_tags($this->productDescription));
        $this->productPrice = htmlspecialchars(strip_tags($this->productPrice));

        $statement->bindParam(':id', $this->productId);
        $statement->bindParam(':name',$this->productName);
        $statement->bindParam(':description',$this->productDescription);
        $statement->bindParam(':price',$this->productPrice);

        if($statement->execute())
        {
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;

    }

    public function delete(){
        $query = 'DELETE FROM PRODUCT WHERE ProductID =:id';
        $statement = $this->connection->prepare($query);
        $this->productId = htmlspecialchars(strip_tags($this->productId));

        $statement->bindParam(':id',$this->productId);

        if($statement->execute())
        {
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;


    }


}