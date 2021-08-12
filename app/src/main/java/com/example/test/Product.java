package com.example.test;

public class Product {

    private int ProductID;
    private String ProductName;
    private String ProductDescription;
    private double ProductPrice;
    private int Quantity;

    public Product(String productName, String productDescription, double productPrice) {
        ProductName = productName;
        ProductDescription = productDescription;
        ProductPrice = productPrice;
    }

    public int getProductID() {
        return ProductID;
    }

    public String getProductName() {
        return ProductName;
    }

    public String getProductDescription() {
        return ProductDescription;
    }

    public double getProductPrice() {
        return ProductPrice;
    }

    public int getQuantity() {
        return Quantity;
    }
}
