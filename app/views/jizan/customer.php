<!DOCTYPE html>
<html>
<head>
	<title><?php echo $basic[0]->accname; ?></title>
	<?php echo HTML::style('css/style.css');?>
	<?php echo HTML::script('js/chart.js');?>
	<?php echo HTML::script('js/gauge.min.js');?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto">
</head>
<body style="font-family:Roboto; font-size: 0.9em">
	<div id="cust_name" style="background-color:#D3D3D3;padding-top:1px;padding-bottom:1px;text-align:center;font-weight:700">
	<h3><?php echo $basic[0]->accname; ?></h3>
	</div>
	<hr>
	<table width="100%" id="basic_info">
		<tr style="background-color:#D3D3D3">
			<th align="center">Account Code</th>
			<th align="center">Location</th>
			<th align="center">Group</th>
			<th align="center">Credit Terms</th>
			<th align="center">Collection Period</th>
			<th align="center">Credit Limit</th>
			<th align="center">Status</th>
			<th align="center">Remarks</th>
		</tr>
		<tr>
			<td align="center"><?php echo $basic[0]->acc_code; ?></td>
			<td align="center"><?php echo $basic[0]->location; ?></td>
			<td align="center"><?php echo $basic[0]->grp; ?></td>
			<td align="center"><?php echo $basic[0]->cr_period; ?></td>
			<td align="center"><?php echo $basic[0]->col_period; ?></td>
			<td align="center"><?php echo number_format($basic[0]->cr_limit,2); ?></td>
			<td align="center"><?php echo $basic[0]->status; ?></td>
			<td align="center"><?php echo $basic[0]->remarks; ?></td>
		</tr>
	</table>
	<hr>
	<?php if (isset($overdue[0])) { ?>

	<h3>Overdue</h3>
	<div id = "prop_table" style="float:left; min-width: 50%" >
	<table width="100%" style="margin-left: 2%;border-collapse:collapse">
		<tr style="background-color:#D3D3D3">
			<th align="left">Bill Number</th>
			<th>Bill Date</th>
			<th>Days</th>
			<th align="right">Amount</th>
		</tr>
	<?php $total_overdue = 0; foreach ($overdue as $od) { ?>
		<tr>
			<td align="left"><?php echo $od->bill_no; ?></td>
			<td align="center"><?php echo $od->bill_date; ?></td>
			<td align="center"><?php echo $od->overdue; ?></td>
			<td align="right"><?php echo number_format($od->amount,2); ?></td>
		</tr>
	<?php $total_overdue = $od->amount + $total_overdue; } ?>
		<tr>
			<th></th>
			<th></th>
			<th style="background-color:#D3D3D3" align = "center" >Total</th>
			<th style="background-color:#D3D3D3" align="right"><?php echo number_format((double) $total_overdue,2); ?></th>
		</tr>
	</table>
	</div>
	<div id = "graph" style="float:left;margin-left:7%">
			
			<canvas id="canvas_prop" align="center" height="138" width="216"></canvas>
			
			<p align="center"><span style="color:#F38630">Overdues</span> vs <span style="color:#458B00">Normal Dues</span></p>
	</div>
	<div id = "graph" style="float:left;margin-left:2%">
			
			
			<canvas id="canvas_gauge" align="center" height="138" width="216"></canvas>
			<p align="center">Credit Limit Used : <?php echo number_format(($totalos[0]->totamt / $basic[0]->cr_limit * 100),0) . "%" ?></p>
	</div>
	<script>
		var data_prop = [
	{
		value: <?php echo (int) (($total_overdue / $totalos[0]->totamt)*100) ?>,
		color: "#F38630"
	},
	{
		value : <?php echo (int) ((($totalos[0]->totamt - $total_overdue) / $totalos[0]->totamt) *100)?>,
		color : "#458B00"
	},

];

	var myPie = new Chart(document.getElementById("canvas_prop").getContext("2d")).Pie(data_prop);

	var opts = {
  lines: 12, // The number of lines to draw
  angle: 0.15, // The length of each line
  lineWidth: 0.44, // The line thickness
  pointer: {
    length: 0.9, // The radius of the inner circle
    strokeWidth: 0.035, // The rotation offset
    color: '#000000' // Fill color
  },
  limitMax: false,   // If true, the pointer will not go past the end of the gauge
  colorStart: '#6FADCF',   // Colors
  colorStop: '#8FC0DA',    // just experiment with them
  strokeColor: '#E0E0E0',   // to see which ones work best for you
  generateGradient: true
};
var target = document.getElementById('canvas_gauge'); // your canvas element
var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
gauge.maxValue = <?php echo $basic[0]->cr_limit ?>; // set max gauge value
gauge.animationSpeed = 32; // set animation speed (32 is default value)
gauge.set(<?php echo ($totalos[0]->totamt > $basic[0]->cr_limit) ? $basic[0]->cr_limit : (int) $totalos[0]->totamt ?>); // set actual value



	</script>
	<div style="clear:both">
	<br>
	<hr>
	</div>	
	<?php } ?>
</body>
</html>