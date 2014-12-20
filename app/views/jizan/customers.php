<!DOCTYPE html>
<html>
<head>
	<title>Jizan :: Customers</title>
</head>
<body>
	<?php foreach ($customers as $customer) {?>
		<p><?php echo $customer->accname .":" . $customer->location; ?></p>
	<?php } ?>
</body>
</html>