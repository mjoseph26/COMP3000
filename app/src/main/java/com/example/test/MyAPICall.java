package com.example.test;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.DELETE;
import retrofit2.http.GET;
import retrofit2.http.PATCH;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Path;
import retrofit2.http.Query;

public interface MyAPICall {
    //http://localhost/Restaurant/API/      read.php

    @GET("Restaurant/API/Order/read.php")
    Call<List<Order>> getOrder();

    /*
    @GET("Restaurant/API/Order/read.php")
    Call<List<Order>> getOrders(
            @Query("OrderID") int OrderID,
            @Query("OrderTime") String OrderTime,
            @Query("TotalPrice") double TotalPrice
    );*/

    @GET("Restaurant/API/Order/read_single.php")
    Call<Order> getSingleOrder(@Query("OrderID") int OrderID);

    @GET("Restaurant/API/Order/read_orderproducts.php")
    Call<List<Product>> getOrderProducts(@Query("OrderID") int OrderID);

    @GET("Restaurant/API/Order/read_dailyorders.php")
    Call<List<Order>> getDailyOrders();

    @POST("Restaurant/API/Order/create.php")
    Call<Order> createOrder(@Body Order order);


    @PUT("Restaurant/API/Order/update.php")
    Call<Order> updateOrder(@Query("OrderID") int OrderID, @Body
                            Order order);

    @DELETE("Restaurant/API/Order/delete.php")
    Call<Void> deleteOrder(@Query("OrderID") int OrderID);

    @GET("Restaurant/API/Product/read.php")
    Call<List<Product>> getProduct();

    @GET("Restaurant/API/Product/read_single.php")
    Call<Product> getSingleProduct(@Query("ProductID") int ProductID);

    @POST("Restaurant/API/Product/create.php")
    Call<Product> createProduct(@Body Product product);

    @PUT("Restaurant/API/Product/update.php")
    Call<Product> updateProduct(@Query("ProductID") int ProductID, @Body
            Product product);

    @DELETE("Restaurant/API/Product/delete.php")
    Call<Void> deleteProduct(@Query("ProductID") int ProductID);
}
