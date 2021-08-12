package com.example.test;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class OrderView extends AppCompatActivity {

    MyAPICall myAPICall;
    ListView listView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order_view);
        Retrofit retrofit = new Retrofit.Builder()

                .baseUrl("http://192.168.0.48:80/")
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        myAPICall = retrofit.create(MyAPICall.class);
        getOrders();
    }

    private void getOrders()
    {
        Call<List<Order>> call = myAPICall.getOrder();
        call.enqueue(new Callback<List<Order>>() {
            @Override
            public void onResponse(Call<List<Order>> call, Response<List<Order>> response) {


                List<Order> orders = response.body();

                listView = findViewById(R.id.listView);
                ArrayList<String> orderList = new ArrayList<String>();
                for(Order order : orders)
                {
                    String content = "";
                    content += "OrderID: " + order.getOrderID() +"\n";
                    content += "OrderTime: " + order.getOrderTime() +"\n";
                    content += "TotalPrice: " + order.getOrderPrice() +"\n";
                    orderList.add(content);

                }
                ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(getApplicationContext(), android.R.layout.simple_list_item_1,orderList);
                listView.setAdapter(arrayAdapter);
                listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                    @Override
                    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                        Intent intent = new Intent(getApplicationContext(),OrderDetails.class);
                        intent.putExtra("OrderID",Integer.toString(orders.get(position).getOrderID()));
                        startActivity(intent);
                    }
                });
            }

            @Override
            public void onFailure(Call<List<Order>> call, Throwable t) {

            }
        });
    }
}