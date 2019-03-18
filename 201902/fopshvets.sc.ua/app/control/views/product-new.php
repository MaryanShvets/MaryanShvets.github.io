<html>
<head>
	<title>Создать страницу</title>

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/header.php');

	?>

</head>	
<body class="page-product-edit">

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/menu.php');
	?>

	<div id="content">

		<h1>Создать страницу</h1>

		<form action="/app/control/api/control/new_product.php" method="POST" style="margin-left: 25px; margin-right:25px;margin-top:25px; background: #ececec; display: inline-block; padding: 10px; border-radius: 3px;">
			<input type="text" name="amoName" placeholder="Название страницы" required><br>
			<input type="submit" class=" btn green " value="Создать">
		</form>

		<?
			// ini_set('display_errors', 1);

			// $id=$_GET['id'];
			
			// $api->connect();

			// $data = mysql_query(" SELECT `id`, `amoName`, `amoTags`, `amoPrice`, `amoview`, `grview`, `grNew`, `grEnd`, `URL`, `redirect`, `smsview`, `SmS`, `category` FROM `products` WHERE `id` ='$id' LIMIT 1") or die(mysql_error());
			
			// while ($row = mysql_fetch_assoc($data)) {
			// 	echo '<h1>'.$row['amoName'].'</h1><br>';
			// 	echo '<form id="form" style="margin-left: 25px; margin-right:25px;margin-top:25px; background: #ececec; display: inline-block; padding: 10px; border-radius: 3px;">';
			// 	foreach ($row as $key => $val)
			//         {	
			//         	echo '<div style="display: inline-block; margin: 10px; box-sizing: border-box; width: 30%;">';
			//         	echo '<span>'.$key.'</span><br>';
			//         	echo '<input style="width:100%;" type="text" name="'.$key.'" id="'.$key.'" value="'.$val.'">';
			//         	echo '</div>';
			//         }
			// }

			// echo '</form>';

		?>
		<br>

	</div>

	

	<div id="loading">
		<div class="cssload-container">
			<div class="cssload-whirlpool"></div>
		</div>

		<p>Сохраняем изменения</p>
	</div>

	<!-- <script type="text/javascript">
		$(document).ready(function() { 
			$('#submit').click(function(){

				$('#loading').fadeIn();

				 $.ajax({
		           type: "POST",
		           url: 'http://polza.com/app/control/api/control/edit_product.php',
		           data: $("#form").serialize(), // serializes the form's elements.
		           success: function(data)
		           {
		               // alert(data); // show response from the php script.
		           }
			         }).done(function() {
					  $('#loading').fadeOut();
					});

		   //       $.ajax({
					//   url: "test.html",
					//   context: document.body
					// }).done(function() {
					//   $( this ).addClass( "done" );
					// });
			});


		});
	</script> -->


</body>
</html>

