<!DOCTYPE html>
<html>
<head>
	<title>JIZAN :: Receivables</title>
	<?php echo HTML::style('css/style.css');?>
</head>
<body>
<h1>JIZAN PERFUMES LLC</h1>
<h3>Receivables Management</h3>
<?php echo link_to_action('ReceivableController@get_jizcustdata', "Fetch Customer Data", $parameters = array(), $attributes = array()); ?>
<br>
<br>
<?php echo link_to_action('ReceivableController@get_jizcustbal', "Fetch Customer Balance", $parameters = array(), $attributes = array()); ?>
<h3>Reports / Analysis</h3>
<?php echo link_to_action('ReceivableController@jiz_recanalysis', "Go", $parameters = array(), $attributes = array()); ?>
</body>
</html>