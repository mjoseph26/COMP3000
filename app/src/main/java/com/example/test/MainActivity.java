package com.example.test;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class MainActivity extends AppCompatActivity {

    TextView textView;
    MyAPICall myAPICall;
    ListView orderList;
    Button orderButton;
    Button menuButton;
    Button statsButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        orderButton = findViewById(R.id.orderButton);
        orderButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                viewOrders();
            }
        });

        menuButton = findViewById(R.id.menuButton);
        menuButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                viewMenu();
            }
        });

        statsButton = findViewById(R.id.statsButton);
        statsButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                viewStats();
            }
        });


        textView = findViewById(R.id.textView);
        Retrofit retrofit = new Retrofit.Builder()

                .baseUrl("http://192.168.0.48:80/")
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        myAPICall = retrofit.create(MyAPICall.class);


        //getOrders();
        //getSingleOrder();
        //createOrder();
        //updateOrder();
        //deleteOrder();
        //getProducts();
        //createProduct();
        //updateProduct();
        //deleteProduct();
        //getOrderProducts();

    }

    private void viewOrders()
    {
        Intent intent = new Intent(this,OrderView.class);
        startActivity(intent);
    }

    private void viewMenu()
    {
        Intent intent = new Intent(this,Menu.class);
        startActivity(intent);
    }

    private void viewStats()
    {
        Intent intent = new Intent(this,Statistics.class);
        startActivity(intent);
    }


    private void getOrders()
    {
        Call<List<Order>> call = myAPICall.getOrder();
        call.enqueue(new Callback<List<Order>>() {
            @Override
            public void onResponse(Call<List<Order>> call, Response<List<Order>> response) {
                if(!response.isSuccessful())
                {
                    textView.setText("Code: " + response.code());
                    return;
                }

                List<Order> orders = response.body();
                for(Order order : orders)
                {
                    String content = "";
                    content += "OrderID: " + order.getOrderID() +"\n";
                    content += "OrderTime: " + order.getOrderTime() +"\n";
                    content += "TotalPrice: " + order.getOrderPrice() +"\n";

                    textView.append(content);
                }
            }

            @Override
            public void onFailure(Call<List<Order>> call, Throwable t) {
                textView.setText(t.getMessage());
            }
        });
    }

    private void getProducts()
    {
        Call<List<Product>> call = myAPICall.getProduct();
        call.enqueue(new Callback<List<Product>>() {
            @Override
            public void onResponse(Call<List<Product>> call, Response<List<Product>> response) {
                if(!response.isSuccessful())
                {
                    textView.setText("Code: " + response.code());
                    return;
                }

                List<Product> products = response.body();
                for(Product product : products)
                {
                    String content = "";
                    content += "ProductID: " + product.getProductID() +"\n";
                    content += "ProductName: " + product.getProductName() +"\n";
                    content += "ProductDescription: " + product.getProductDescription() +"\n";
                    content += "ProductPrice: " + product.getProductPrice() +"\n";

                    textView.append(content);
                }
            }

            @Override
            public void onFailure(Call<List<Product>> call, Throwable t) {
                textView.setText(t.getMessage());
            }
        });
    }


    private void getSingleOrder()
    {
        Call<Order> call = myAPICall.getSingleOrder(1);
        call.enqueue(new Callback<Order>() {
            @Override
            public void onResponse(Call<Order> call, Response<Order> response) {
                if(!response.isSuccessful())
                {
                    textView.setText("Code: " + response.code());
                    return;
                }
                Order order = response.body();
                String content = "";
                content += "OrderID: " + order.getOrderID() +"\n";
                content += "OrderTime: " + order.getOrderTime() +"\n";
                content += "TotalPrice: " + order.getOrderPrice() +"\n";

                textView.append(content);
            }

            @Override
            public void onFailure(Call<Order> call, Throwable t) {
                textView.setText(t.getMessage());
            }
        });

    }

    private void getSingleProduct()
    {
        Call<Product> call = myAPICall.getSingleProduct(1);
        call.enqueue(new Callback<Product>() {
            @Override
            public void onResponse(Call<Product> call, Response<Product> response) {
                if(!response.isSuccessful())
                {
                    textView.setText("Code: " + response.code());
                    return;
                }
                Product product = response.body();
                String content = "";
                content += "ProductID: " + product.getProductID() +"\n";
                content += "ProductName: " + product.getProductName() +"\n";
                content += "ProductDescription: " + product.getProductDescription() +"\n";
                content += "ProductPrice: " + product.getProductPrice() +"\n";

                textView.append(content);
            }

            @Override
            public void onFailure(Call<Product> call, Throwable t) {
                textView.setText(t.getMessage());
            }
        });

    }

    private void createOrder()
    {
        Order order = new Order("2020-03-11 21:30:00",90.3);
        Call<Order> call = myAPICall.createOrder(order);
        call.enqueue(new Callback<Order>() {
            @Override
            public void onResponse(Call<Order> call, Response<Order> response) {

                if(!response.isSuccessful())
                {
                    textView.setText("Code: " + response.code());
                    return;
                }

            }


            @Override
            public void onFailure(Call<Order> call, Throwable t) {
                textView.setText(t.getMessage());
            }
        });
    }

    private void createProduct()
    {
        Product product = new Product("Lamb","Meat from sheep",6.50);
        Call <Product> call = myAPICall.createProduct(product);
        call.enqueue(new Callback<Product>() {
            @Override
            public void onResponse(Call<Product> call, Response<Product> response) {
                if(!response.isSuccessful())
                {
                    textView.setText("Code: " + response.code());
                    return;
                }

            }

            @Override
            public void onFailure(Call<Product> call, Throwable t) {
                textView.setText(t.getMessage());
            }
        });
    }



    private void updateOrder()
    {
        Order order = new Order("2020-03-11 21:30:00",54.3);
        Call <Order> call = myAPICall.updateOrder(16,order);
        call.enqueue(new Callback<Order>() {
            @Override
            public void onResponse(Call<Order> call, Response<Order> response) {
                if(!response.isSuccessful())
                {
                    textView.setText("Code: " + response.code());
                    return;
                }
            }

            @Override
            public void onFailure(Call<Order> call, Throwable t) {
                textView.setText(t.getMessage());
            }
        });
    }

    private void updateProduct()
    {
        Product product = new Product("Turkey","Meat from Turkey", 10.65);
        Call <Product> call = myAPICall.updateProduct(3,product);
        call.enqueue(new Callback<Product>() {
            @Override
            public void onResponse(Call<Product> call, Response<Product> response) {
                if(!response.isSuccessful())
                {
                    textView.setText("Code: " + response.code());
                    return;
                }
            }

            @Override
            public void onFailure(Call<Product> call, Throwable t) {
                textView.setText(t.getMessage());
            }
        });
    }



    private void deleteOrder()
    {
        Call<Void> call = myAPICall.deleteOrder(9);
        call.enqueue(new Callback<Void>() {
            @Override
            public void onResponse(Call<Void> call, Response<Void> response) {
                textView.setText("Code: " + response.code());
            }

            @Override
            public void onFailure(Call<Void> call, Throwable t) {
                textView.setText(t.getMessage());
            }
        });
    }

    private void deleteProduct()
    {
        Call<Void> call = myAPICall.deleteProduct(1);
        call.enqueue(new Callback<Void>() {
            @Override
            public void onResponse(Call<Void> call, Response<Void> response) {
                textView.setText("Code: " + response.code());
            }

            @Override
            public void onFailure(Call<Void> call, Throwable t) {
                textView.setText(t.getMessage());
            }
        });
    }

    private void getOrderProducts() {
        Call<List<Product>> call = myAPICall.getOrderProducts(1);
        call.enqueue(new Callback<List<Product>>() {
            @Override
            public void onResponse(Call<List<Product>> call, Response<List<Product>> response) {
                if (!response.isSuccessful()) {
                    textView.setText("Code: " + response.code());
                    return;
                }
                List<Product> products = response.body();
                for (Product product : products) {
                    String content = "";
                    content += "ProductName: " + product.getProductName() + "\n";
                    content += "ProductPrice: " + product.getProductPrice() + "\n";

                    textView.append(content);
                }
            }

            @Override
            public void onFailure(Call<List<Product>> call, Throwable t) {
                textView.setText(t.getMessage());
            }

        });


    }

    private void getDailyOrders()
    {
        Call <List<Order>> call = myAPICall.getDailyOrders();
        call.enqueue(new Callback<List<Order>>() {
            @Override
            public void onResponse(Call<List<Order>> call, Response<List<Order>> response) {
                if(!response.isSuccessful())
                {
                    textView.setText("Code: " + response.code());
                    return;
                }
                List<Order> orders = response.body();
                for(Order order : orders)
                //find 7 dates and the total order price for each date
                {
                    String content = "";
                    content += "OrderTime: " + order.getOrderTime() +"\n";
                    content += "OrderPrice: " + order.getOrderPrice() +"\n";

                    textView.append(content);
                }
            }
            @Override
            public void onFailure(Call<List<Order>> call, Throwable t) {
                textView.setText(t.getMessage());
            }

        });


    }
}