package com.example.test;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class EditMenu extends AppCompatActivity {
    MyAPICall myAPICall;
    EditText nameTxt,descriptionTxt,priceTxt;
    Button editButton,deleteButton;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_edit_menu);

        Retrofit retrofit = new Retrofit.Builder()

                .baseUrl("http://192.168.0.48:80/")
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        myAPICall = retrofit.create(MyAPICall.class);

        Intent intent = getIntent();
        String received = intent.getStringExtra("ProductID");
        int productID = Integer.parseInt(received);
        getSingleProduct(productID);

        nameTxt = findViewById(R.id.nameTxt);
        descriptionTxt = findViewById(R.id.descriptionTxt);
        priceTxt = findViewById(R.id.priceTxt);

        editButton = findViewById(R.id.editButton);
        editButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (nameTxt.getText().toString().equals("") || priceTxt.getText().toString().equals(""))
                {
                    Toast.makeText(getApplicationContext(), "Please ensure that appropriate values are provided for the fields", Toast.LENGTH_LONG).show();
                } else {
                    updateProduct(productID);
                }

            }
        });

        deleteButton = findViewById(R.id.deleteButton);
        deleteButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                deleteProduct(productID);
            }
        });
    }

    private void getSingleProduct(int productID)
    {
        Call<Product> call = myAPICall.getSingleProduct(productID);
        call.enqueue(new Callback<Product>() {
            @Override
            public void onResponse(Call<Product> call, Response<Product> response) {

                Product product = response.body();
                nameTxt = findViewById(R.id.nameTxt);
                descriptionTxt = findViewById(R.id.descriptionTxt);
                priceTxt = findViewById(R.id.priceTxt);
                nameTxt.setText(product.getProductName());
                descriptionTxt.setText(product.getProductDescription());
                priceTxt.setText(String.valueOf(product.getProductPrice()));
            }

            @Override
            public void onFailure(Call<Product> call, Throwable t) {
            }
        });

    }

    private void updateProduct(int ProductID)
    {

        String name = nameTxt.getText().toString();
        String description = descriptionTxt.getText().toString();
        Double price = Double.parseDouble(priceTxt.getText().toString());
        Product product = new Product(name,description, price);
        Call <Product> call = myAPICall.updateProduct(ProductID,product);
        call.enqueue(new Callback<Product>() {
            @Override
            public void onResponse(Call<Product> call, Response<Product> response) {
                Toast.makeText(getApplicationContext(),"Product has been updated successfully",Toast.LENGTH_LONG).show();
            }

            @Override
            public void onFailure(Call<Product> call, Throwable t) {
                Toast.makeText(getApplicationContext(),"Product could not be updated",Toast.LENGTH_LONG).show();
            }
        });
    }

    private void deleteProduct(int productID)
    {
        Call<Void> call = myAPICall.deleteProduct(productID);
        nameTxt.setText("");
        descriptionTxt.setText("");
        priceTxt.setText("");
        call.enqueue(new Callback<Void>() {
            @Override
            public void onResponse(Call<Void> call, Response<Void> response) {
                Toast.makeText(getApplicationContext(),"Product has been deleted successfully",Toast.LENGTH_LONG).show();
            }

            @Override
            public void onFailure(Call<Void> call, Throwable t) {
                Toast.makeText(getApplicationContext(),"Product could not be deleted",Toast.LENGTH_LONG).show();
            }
        });
    }

}