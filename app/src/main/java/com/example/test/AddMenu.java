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

public class AddMenu extends AppCompatActivity {

    EditText nameEditText, descriptionEditText, priceEditText;
    Button submitButton;
    MyAPICall myAPICall;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_menu);
        Retrofit retrofit = new Retrofit.Builder()

                .baseUrl("http://192.168.0.48:80/")
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        myAPICall = retrofit.create(MyAPICall.class);
        Intent intent = getIntent();
        String received = intent.getStringExtra("ProductID");
        nameEditText = findViewById(R.id.nameTxt);
        descriptionEditText = findViewById(R.id.descriptionTxt);
        priceEditText = findViewById(R.id.priceTxt);

        submitButton = findViewById(R.id.editButton);
        submitButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (nameEditText.getText().toString().equals("") || priceEditText.getText().toString().equals("")) {
                    Toast.makeText(getApplicationContext(), "Please ensure that appropriate values are provided for the fields", Toast.LENGTH_LONG).show();
                } else {
                    createProduct();
                }
            }
        });
    }

    private void createProduct() {
        String name = nameEditText.getText().toString();
        String description = descriptionEditText.getText().toString();
        Double price = Double.parseDouble(priceEditText.getText().toString());
        Product product = new Product(name, description, price);
        Call<Product> call = myAPICall.createProduct(product);
        call.enqueue(new Callback<Product>() {
            @Override
            public void onResponse(Call<Product> call, Response<Product> response) {
                Toast.makeText(getApplicationContext(), "Product has been created successfully", Toast.LENGTH_LONG).show();
            }

            @Override
            public void onFailure(Call<Product> call, Throwable t) {
                Toast.makeText(getApplicationContext(), "Product has not been created", Toast.LENGTH_LONG).show();
            }
        });
    }


}