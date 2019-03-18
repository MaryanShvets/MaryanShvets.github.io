<?
	
	// include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	// $api = new API();
	// $api->connect();

	// $product = $api->query(" SELECT * FROM `products` WHERE `category` !='aмо new lead' ORDER BY id DESC ");
	// $product = mysql_query(" SELECT * FROM `products` WHERE `category` !='aмо new lead' ORDER BY id ASC ") or die(mysql_error());

?>

<html>
<head>
	<title>Отчеты</title>

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/header.php');

	?>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.query-builder/2.4.1/js/query-builder.standalone.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.query-builder/2.4.1/css/query-builder.default.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="/app/control/frontend/css/boot.css"> -->

</head>	
<body class="page-report">

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/menu.php');
	?>

	<div id="content">


	<?

		// dzhadan_money-start

		$products = mysql_query(" SELECT `id`,`amoName`  FROM `products` WHERE  `id` IN(SELECT `product` FROM `app_leads` WHERE `utmmedium` = 'dzhadan_money-start')  ") or die(mysql_error());
		
		echo '<table>';
		while ($row = mysql_fetch_array($products)) {

			$id = $row['id'];
			$name = $row['amoName'];

			$leads = $api->query(" SELECT COUNT(*) as count FROM `app_leads` WHERE `product` = '$id' AND `utmmedium` = 'dzhadan_money-start' LIMIT 1");
			$sales = $api->query(" SELECT COUNT(*) as count FROM `app_leads` WHERE `product` = '$id' AND `status` = '142' AND `utmmedium` = 'dzhadan_money-start' LIMIT 1");

			echo '<tr>';
			echo '<td>'.$name.' ('.$id.')</td>';
			echo '<td>'.$leads['count'].'</td>';
			echo '<td>'.$sales['count'].'</td>';
			echo '</tr>';
			// echo '<div class="items">'.$row['date_create'].' / '.$row['status'].' / '.$row['order_desc'].'</div>';
		}
		echo '</table>';
	?>


	</div>

	

	<div id="loading">
		<div class="cssload-container">
			<div class="cssload-whirlpool"></div>
		</div>

		<p>Сохраняем изменения</p>
	</div>

	<script type="text/javascript">


		// $(document).ready(function() { 
		// 	$('#submit').click(function(){

		// 		$('#loading').fadeIn();

		// 		 $.ajax({
		//            type: "POST",
		//            url: 'http://polza.com/app/control/api/control/edit_product.php',
		//            data: $("#form").serialize(), // serializes the form's elements.
		//            success: function(data)
		//            {
		//            }
		// 	         }).done(function() {
		// 			  $('#loading').fadeOut();
		// 			});

		// 	});


		// });
	</script>


</body>
</html>

