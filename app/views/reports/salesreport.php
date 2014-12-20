<?php 
		$days_t = array();
		$sales_t = array();
		$qty_t = array();
		$profit_t = array();
		foreach ($data_trend as $daily) {
			$days_t[] = (string) $daily->date;
			$sales_t[] = $daily->saleamt;
			$qty_t[] = $daily->qty;
			$profit_t[] = $daily->profit;
		}

		$date_trend = '["' . implode('", "', $days_t) . '"]';
		$qty_trend = '[' . implode(',', $qty_t) . ']';
		$saleamt_trend = '[' . implode(',', $sales_t) . ']';
		$profit_trend = '[' . implode(',', $profit_t) . ']';

		?>
		

<!doctype html>
<html>
	<head>
		<title>Radar Chart</title>
		<?php echo HTML::style('css/style2.css');?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<?php echo HTML::script('hc/js/highcharts.js'); ?>
		<?php echo HTML::script('hc/js/modules/exporting.js'); ?>
		<?php echo HTML::script('js/chart.js');?>
		<?php echo HTML::script('js/jquery.tablesorter.js');?>
		<meta name = "viewport" content = "initial-scale = 1, user-scalable = no">
		<style>
			canvas{
			}
		</style>
	</head>
	<body>
		<h1>INTER CITY PERFUMES LLC</h1>
		<div id = "graph">
			<h3>Sales vs Profit Trend</h3>
			<canvas id="canvas_trend" height="345" width="540"></canvas>
		</div>
		<div id = "graph">
			<h3>Quantity Trend</h3>
			<canvas id="canvas_trend_qty" height="345" width="540"></canvas>
		</div>

		<div id = "graph">
			<h3>Sales vs Profit</h3>
			<canvas id="canvas_sales" height="345" width="540"></canvas>
		</div>
		<div id = "graph">
			<h3>Quantity</h3>
			<canvas id="canvas_qty" height="345" width="540"></canvas>
		</div>
		

	<script>

		$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 

		var data_trend = {
		labels : <?php echo $date_trend;?>,
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				data : <?php echo $saleamt_trend;?>
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : <?php echo $profit_trend;?>
			}
		]}

		var data_trend_qty = {
		labels : <?php echo $date_trend;?>,
		datasets : [
			
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : <?php echo $qty_trend;?>
			}
		]}

		var data_sales = {
		labels : <?php echo $salesman;?>,
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				data : <?php echo $saleamt;?>
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : <?php echo $profit;?>
			}
		]}

		var data_qty = {
		labels : <?php echo $salesman;?>,
		datasets : [
			
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				pointColor : "rgba(151,187,205,1)",
				pointStrokeColor : "#fff",
				data : <?php echo $qty;?>
			}
		]}

	var myPie = new Chart(document.getElementById("canvas_sales").getContext("2d")).Line(data_sales);
	var myPie2 = new Chart(document.getElementById("canvas_qty").getContext("2d")).Line(data_qty);
	var myPieTrend = new Chart(document.getElementById("canvas_trend").getContext("2d")).Line(data_trend);
	var myPieTrend2 = new Chart(document.getElementById("canvas_trend_qty").getContext("2d")).Line(data_trend_qty);
	</script>
	<div id = "content" style="clear: both">
	<br>
	<?php echo link_to('/lossreport', "<< Sales Reports", $attributes = array(), $secure = null); ?>
	</div>

	NEW CHART HERE
	<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'INTER CITY PERFUMES LLC'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'SALES TREND LINE' :
                    'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime',
                minRange: 14 * 24 * 3600000 // fourteen days
            },
            yAxis: {
                title: {
                    text: 'Sales'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
    
            series: [{
                type: 'area',
                name: 'Sales',
                pointInterval: 24 * 3600 * 1000,
                pointStart: Date.UTC(2006, 0, 01),
                data: <?php echo $saleamt_trend;?>
            }]
        });
    });
    
		
		</script>
		<div id="container" style="min-width: 210px; height: 400px; margin: 0 auto"></div>

	</body>
</html>

