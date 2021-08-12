package com.example.test;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class Menu extends AppCompatActivity {

    MyAPICall myAPICall;
    ListView menuListView;
    Button addButton;
    List<Product> products;
    Retrofit retrofit;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu);
        retrofit = new Retrofit.Builder()

                .baseUrl("http://192.168.0.48:80/")
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        myAPICall = retrofit.create(MyAPICall.class);
        addButton = findViewById(R.id.addButton);
        addButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                viewAddEditPage();
            }
        });
        getProducts();
    }

    @Override
    protected void onResume() {
        super.onResume();

        myAPICall = retrofit.create(MyAPICall.class);
        getProducts();
    }


    private void viewAddEditPage() {
        Intent intent = new Intent(this, AddMenu.class);
        startActivity(intent);
    }


    private void getProducts() {
        Call<List<Product>> call = myAPICall.getProduct();
        call.enqueue(new Callback<List<Product>>() {
            @Override
            public void onResponse(Call<List<Product>> call, Response<List<Product>> response) {

                products = response.body();
                menuListView = findViewById(R.id.menuListView);
                ArrayList<String> productList = new ArrayList<String>();
                for (Product product : products) {
                    String content = "";
                    content += "ProductID: " + product.getProductID() + "\n";
                    content += "ProductName: " + product.getProductName() + "\n";
                    content += "ProductDescription: " + product.getProductDescription() + "\n";
                    content += "ProductPrice: " + product.getProductPrice() + "\n";

                    productList.add(content);
                }
                ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(getApplicationContext(), android.R.layout.simple_list_item_1, productList);
                menuListView.setAdapter(arrayAdapter);
                menuListView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                    @Override
                    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                        Intent intent = new Intent(getApplicationContext(), EditMenu.class);
                        intent.putExtra("ProductID", Integer.toString(products.get(position).getProductID()));
                        startActivity(intent);
                    }
                });
            }

            @Override
            public void onFailure(Call<List<Product>> call, Throwable t) {
            }
        });
    }
}