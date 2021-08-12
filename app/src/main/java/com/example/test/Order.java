package com.example.test;

import com.google.gson.annotations.SerializedName;

public class Order {

    private int OrderID;
    private String OrderTime;

    @SerializedName("TotalPrice")
    private double OrderPrice;

    public Order(String orderTime, double orderPrice) {
        OrderTime = orderTime;
        OrderPrice = orderPrice;
    }

    public int getOrderID() {
        return OrderID;
    }

    public String getOrderTime() {
        return OrderTime;
    }

    public double getOrderPrice() {
        return OrderPrice;
    }


}
