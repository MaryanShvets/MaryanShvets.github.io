<table>

	<?

		ini_set('display_errors', 1);
		
		$data = mysql_query(" SELECT * FROM `app_payments_config` WHERE `system` = 'privat24' LIMIT 500 ") or die(mysql_error());


		$moneyflow_count = 0;

		while ($row = mysql_fetch_array($data)) {

			$requesst_id = $row['key2'];
 			$requesst_pass = $row['key3'];
 			$requesst_card = $row['key1'];

 			$requesst_url = 'http://polza.com/app/api/privatbank/control/get_payments.php';
 			$requesst_url.= '?id='.$requesst_id.'&pass='.$requesst_pass.'&card='.$requesst_card;

 			// echo '<pre>';
 			// echo file_get_contents($requesst_url);

 			$moneyflow = file_get_contents($requesst_url);
 			// $moneyflow = json_decode($moneyflow, JSON_OBJECT_AS_ARRAY);

 			// echo '<pre>';
 			echo $moneyflow;
 			// $moneyflow[] = json_decode(file_get_contents($requesst_url));

 			// echo '<pre>';
 			// print_r($moneyflow);

			// echo '
			// 	<tr>
			// 		<td>'.file_get_contents($requesst_url).'</td>
			// 		<td>'.$row['description'].'</td>
			// 	</tr>
			// ';

		}

	?>
</table>