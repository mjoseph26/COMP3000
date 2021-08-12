package com.example.test;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.widget.TextView;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class OrderDetails extends AppCompatActivity {

    TextView displayView;
    MyAPICall myAPICall;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order_details);
        Retrofit retrofit = new Retrofit.Builder()

                .baseUrl("http://192.168.0.48:80/")
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        myAPICall = retrofit.create(MyAPICall.class);
        Intent intent = getIntent();
        String received = intent.getStringExtra("OrderID");
        int OrderID = Integer.parseInt(received);
        displayView = findViewById(R.id.displayView);
        //displayView.setText(received);

        getOrderProducts(OrderID);

    }

    private void getOrderProducts(int OrderID)
    {
        Call<List<Product>> call = myAPICall.getOrderProducts(OrderID);
        call.enqueue(new Callback<List<Product>>() {
            @Override
            public void onResponse(Call<List<Product>> call, Response<List<Product>> response) {

                List<Product> products = response.body();
                for(Product product : products)
                {
                    String content = "";
                    content += "ProductName: " + product.getProductName() +"\n";
                    content += "ProductPrice: " + product.getProductPrice() +"\n";
                    content += "Quantity: " + product.getQuantity() + "\n";
                    displayView.setText(content);
                }
            }
            @Override
            public void onFailure(Call<List<Product>> call, Throwable t) {
                displayView.setText(t.getMessage());
            }

        });


    }
}