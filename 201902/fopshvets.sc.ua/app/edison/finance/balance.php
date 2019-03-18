<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

API::connect();

?>

<div class="container dashboard page-balance">
	
	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<!-- <li onclick="aajax('finance/start', 0)" class="ajax" >Финансы</li> -->
		<li>Баланс на счетах</li>
		<li onclick="aajax('finance/balance', 0)" class="ajax" >Обновить</li>
		<li id="finance_income" >Загрузка...</li>
	</ul>

	<br>

	<div class="balance_part">

		<h1>Приват</h1>
		<br>

		<?

			$data = mysql_query(" SELECT * FROM `app_payments_config` WHERE `system` = 'privat24' LIMIT 500 ") or die(mysql_error());
			
			// echo '<table>';
				while ($row = mysql_fetch_array($data)) {

					// $requesst_id = $row['key2'];
		 		// 	$requesst_pass = $row['key3'];
		 		// 	$requesst_card = $row['key1'];

		 			echo '<div class="balance_item">';
						echo '<span class="code"><script type="text/javascript">aajax_privat(\''.$row['id'].'\', \''.$row['key2'].'\', \''.$row['key3'].'\', \''.$row['key1'].'\' );</script></span>';
						echo '<span class="summ" id="privat_'.$row['id'].'">Загрузка...</span>';
						echo '<span class="description">'.$row['description'].'</span>';
					echo '</div>';

		 			// echo '<tr><td style="width:0px;display: none;"><script type="text/javascript">aajax_privat(\''.$row['id'].'\', \''.$row['key2'].'\', \''.$row['key3'].'\', \''.$row['key1'].'\' );</script></td><td style="width:250px;" id="privat_'.$row['id'].'">Загрузка...</td><td>'.$row['description'].'</td></tr>';

				}
			// echo '</table>';

		?>
	</div>

	<div class="balance_part" style="margin-left: 9%;">

		<h1>Фонди</h1>

		<br>

		<?

			$data = mysql_query(" SELECT * FROM `app_payments_config` WHERE `system` = 'fondy' LIMIT 500 ") or die(mysql_error());
			
			// echo '<table>';
				while ($row = mysql_fetch_array($data)) {

					echo '<div class="balance_item">';
						echo '<span class="code"><script type="text/javascript">aajax_fondy(\''.$row['id'].'\', \''.$row['key1'].'\', \''.$row['key2'].'\' );</script></span>';
						echo '<span class="summ" id="fondy_'.$row['id'].'">Загрузка...</span>';
						echo '<span class="description">'.$row['description'].'</span>';
					echo '</div>';

		 			// echo '<tr><td style="width:0px;display: none;"></td><td style="width:250px;" id="fondy_'.$row['id'].'">Загрузка...</td><td>'.$row['description'].'</td></tr>';

				}
			// echo '</table>';

		?>
	</div>
</div>

<script type="text/javascript">
	aajax_finance_income();
</script>
