<?php
include_once 'header.php';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://localhost/Restaurant/API/Order/read_dailyorders.php');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
$output = json_decode($result, true);
curl_close($curl);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://localhost/Restaurant/API/Order/getproductsales.php');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$outcome = curl_exec($curl);
$sales = json_decode($outcome, true);
curl_close($curl);
?>
<!DOCTYPE html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages': ['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawBarChart);
        google.charts.setOnLoadCallback(drawPieChart);


        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawBarChart() {

            // Create the data table.
            var barData = new google.visualization.DataTable();
            barData.addColumn('string', 'Date');
            barData.addColumn('number', 'Daily Revenue');
            barData.addRows([
                <?php
                foreach ($output as $out) {
                    echo "['" . $out['OrderTime'] . "'," . " " . $out['TotalPrice'] . "],";
                }

                ?>
            ]);

            var barchart_options = {
                title: 'Total Revenue From Last 7 Daily Records(in £s)',
                width: 1000,
                height: 600,
                legend: 'none'
            };
            var barchart = new google.visualization.BarChart(document.getElementById('barchart_div'));
            barchart.draw(barData, barchart_options);
        }


        function drawPieChart() {
            var pieData = new google.visualization.DataTable();
            pieData.addColumn('string', 'Product');
            pieData.addColumn('number', 'Share of Quantities Sold');
            pieData.addRows([
                <?php
                foreach ($sales as $sale) {
                echo "['" . $sale['ProductName'] . "'," . " " . $sale['Quantity'] . "],";
                }


                ?>
            ]);
            var piechart_options = {
                title: 'Pie Chart: Share of Sold Quantities',
                width: 1000,
                height: 600
            };
            var piechart = new google.visualization.PieChart(document.getElementById('piechart_div'));
            piechart.draw(pieData, piechart_options);

        }

    </script>
</head>
<body>
<div class="container">
    <div class="text-center">
        <!--Div that will hold the bar chart-->
        <div id="barchart_div"></div>
        <div id="piechart_div"></div>
    </div>

</div>

</body>
</html>