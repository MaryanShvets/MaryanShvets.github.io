<html>
<head>
	<title>Большой брат</title>
	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/header.php');

	?>
</head>	
<body class="page-user-search">

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/menu.php');
	?>

	<div id="content">

		<?
			if(empty($_GET['email'])){
				?>

					<h1>Большой брат ждет указаний</h1>

					<form action="">
						<input type="text" name="email" id="email">
						<input type="hidden" name="view" value="user-search">
						<input type="submit" class=" btn green " name="submit">
					</form>
				<?
			}
			else{

				$api->connect();

				$email = $_GET['email'];

				?>
					<h1>Большой брат нашел <?=$email;?></h1>
				<?

				?>
					<form action="">
						<input type="text" name="email" id="email" value="<?=$email;?>">
						<input type="hidden" name="view" value="user-search">
						<input type="submit" class=" btn green " name="submit">
					</form>
				<?
				
				$contact = $api->query(" SELECT `id` FROM `app_contact` WHERE `email` = '$email' LIMIT 1");
				$contact_id = $contact['id'];

				$submits = mysql_query(" SELECT * FROM `app_leads` WHERE `contact` = '$contact_id' ORDER BY `app_leads`.`id` DESC") or die(mysql_error());
				echo '<h3>Заявки:</h3>';
				while ($row = mysql_fetch_array($submits)) {
					
					$product_id = $row['product'];
					$product = $api->query(" SELECT `amoName` FROM `products` WHERE `id` = '$product_id' LIMIT 1");

					echo '<div class="items">'.$row['data'].' была заявка '.$product['amoName'].' / utm_source '.$row['utmsourse'].' <br>utm_medium '.$row['utmmedium'].' <br>utm_campaigh '.$row['utmcampaing'].' <br>utm_term '.$row['utmterm'].'</div>';
				}


				$payments = mysql_query(" SELECT * FROM `app_payments` WHERE `order_id` IN (SELECT `id` FROM `app_leads` WHERE `contact` in( SELECT `id` FROM `app_contact` WHERE `email` = '$email')) AND `type` = 'payment'") or die(mysql_error());
				echo '<h3>Платежи:</h3>';
				while ($row = mysql_fetch_array($payments)) {

					echo '<div class="items">'.$row['date_create'].' создан платеж / '.$row['status'].'<br>'.$row['order_desc'].'</div>';
				}

				$invoice = mysql_query(" SELECT * FROM `app_payments` WHERE `order_id` IN( SELECT `amo` FROM `app_leads` WHERE `contact` IN ( SELECT `id` FROM `app_contact` WHERE `email` = '$email') AND `amo` !='0' ) AND `type` = 'invoice' ") or die(mysql_error());
				echo '<h3>Выставленные счета:</h3>';
				while ($row = mysql_fetch_array($invoice)) {

					echo '<div class="items">'.$row['date_create'].' / '.$row['status'].' / '.$row['order_desc'].'</div>';
				}
			}
		?>
	</div>
</body>
</html>