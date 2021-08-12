package com.example.test;

import androidx.appcompat.app.AppCompatActivity;

import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.widget.FrameLayout;
import android.widget.TextView;

import com.github.mikephil.charting.charts.BarChart;
import com.github.mikephil.charting.components.Description;
import com.github.mikephil.charting.components.XAxis;
import com.github.mikephil.charting.data.BarData;
import com.github.mikephil.charting.data.BarDataSet;
import com.github.mikephil.charting.data.BarEntry;
import com.github.mikephil.charting.formatter.IndexAxisValueFormatter;
import com.github.mikephil.charting.interfaces.datasets.IBarDataSet;
import com.github.mikephil.charting.interfaces.datasets.IDataSet;
import com.github.mikephil.charting.utils.ColorTemplate;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

import java.text.SimpleDateFormat;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class Statistics extends AppCompatActivity {
    BarChart chart;
    BarData barData;
    BarDataSet barDataSet;
    ArrayList barEntries;
    MyAPICall myAPICall;
    ArrayList<Order> dailyTotal;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_statistics);
        chart = findViewById(R.id.chart);


        Retrofit retrofit = new Retrofit.Builder()

                .baseUrl("http://192.168.0.48:80/")
                .addConverterFactory(GsonConverterFactory.create())
                .build();

        myAPICall = retrofit.create(MyAPICall.class);
        getDailyRevenue();
    }


    private void getDailyRevenue()
    {
        Call<List<Order>> call = myAPICall.getDailyOrders();
        call.enqueue(new Callback<List<Order>>() {
            @Override
            public void onResponse(Call<List<Order>> call, Response<List<Order>> response) {
                List<Order> revenueList = response.body();
                createBarChart(revenueList);
            }

            @Override
            public void onFailure(Call<List<Order>> call, Throwable t) {

            }
        });
    }

    private void createBarChart(List<Order> orderArrayList) {
        ArrayList<BarEntry> values = new ArrayList<>();
        ArrayList<String> severityStringList = new ArrayList<>();

        for (int i = 0; i < orderArrayList.size(); i++) {
            Order order = orderArrayList.get(i);
            values.add(new BarEntry(i, Float.parseFloat(String.valueOf(order.getOrderPrice()))));
            severityStringList.add(order.getOrderTime());
        }

        BarDataSet set1;

        if (chart.getData() != null &&
                chart.getData().getDataSetCount() > 0) {
            set1 = (BarDataSet) chart.getData().getDataSetByIndex(0);
            set1.setValues(values);
            chart.getData().notifyDataChanged();
            chart.notifyDataSetChanged();
        } else {
            set1 = new BarDataSet(values, "Daily revenue in £s over consecutive dates");
            set1.setDrawValues(true);

            ArrayList<IBarDataSet> dataSets = new ArrayList<>();
            dataSets.add(set1);




            BarData data = new BarData(dataSets);
            chart.setData(data);
            chart.setVisibleXRange(1,6);
            chart.setFitBars(true);
            XAxis xAxis = chart.getXAxis();
            xAxis.setGranularity(1f);
            xAxis.setGranularityEnabled(true);
            Description description = new Description();
            description.setText("Date");
            chart.setDescription(description);


            xAxis.setValueFormatter(new IndexAxisValueFormatter(severityStringList));//setting String values in Xaxis
            for (IDataSet set : chart.getData().getDataSets())
                set.setDrawValues(!set.isDrawValuesEnabled());

            chart.invalidate();
        }
    }

    private void initializeBarChart() {
        chart.getDescription().setEnabled(false);

        //set the number of bars to be added
        chart.setMaxVisibleValueCount(7);
        chart.getXAxis().setDrawGridLines(false);
        // scaling can now only be done on x- and y-axis separately
        chart.setPinchZoom(false);
        chart.setDrawBarShadow(false);
        chart.setDrawGridBackground(false);

        XAxis xAxis = chart.getXAxis();
        xAxis.setDrawGridLines(false);

        chart.getAxisLeft().setDrawGridLines(false);
        chart.getAxisRight().setDrawGridLines(false);
        chart.getAxisRight().setEnabled(false);
        chart.getAxisLeft().setEnabled(true);
        chart.getXAxis().setDrawGridLines(false);
        // add a smooth animation
        chart.animateY(1000);
        chart.getLegend().setEnabled(false);
        chart.getAxisRight().setDrawLabels(false);
        chart.getAxisLeft().setDrawLabels(true);
        chart.setTouchEnabled(false);
        chart.setDoubleTapToZoomEnabled(false);
        chart.getXAxis().setEnabled(true);
        chart.getXAxis().setPosition(XAxis.XAxisPosition.BOTTOM);
        chart.invalidate();

    }


}





