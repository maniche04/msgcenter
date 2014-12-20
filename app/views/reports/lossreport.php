<!DOCTYPE html>
<html>
<head>
	<title>Loss Report Generator</title>
	<?php echo HTML::style('css/style.css');?>
</head>
<body>
<h1>INTER CITY PERFUMES LLC</h1>
<h3>Sales Monitoring</h3>
<?php echo link_to_action('ExcelController@lossReport', "Process Data", $parameters = array(), $attributes = array()); ?>
<br>
<br>
<?php echo link_to('/salesreport', "Sales Reports", $attributes = array(), $secure = null); ?>
<br>
<h3>Excel Reports</h3>
<?php echo link_to_action('ExcelController@xllossReport', "Loss Report - Invoices", $parameters = array(), $attributes = array()); ?>
</body>
</html>

