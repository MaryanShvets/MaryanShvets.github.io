<br>
<br>

<h3 style="text-align:center;">Приват</h3>

<table>

	<?
		
		$data = mysql_query(" SELECT * FROM `app_payments_config` WHERE `system` = 'privat24' LIMIT 500 ") or die(mysql_error());
		
		while ($row = mysql_fetch_array($data)) {

			$requesst_id = $row['key2'];
 			$requesst_pass = $row['key3'];
 			$requesst_card = $row['key1'];

 			$requesst_url = 'http://polza.com/app/api/privatbank/control/get_balace.php';
 			$requesst_url.= '?id='.$requesst_id.'&pass='.$requesst_pass.'&card='.$requesst_card;

			echo '
				<tr>
					<td  width="250px;" style="text-align:right;">'.file_get_contents($requesst_url).'</td>
					<td>'.$row['description'].'</td>
				</tr>
			';

		}

	?>

</table>
<h3 style="text-align:center;">Фонди</h3>
<table>

	<?
		
		$data = mysql_query(" SELECT * FROM `app_payments_config` WHERE `system` = 'fondy' LIMIT 500 ") or die(mysql_error());
		
		while ($row = mysql_fetch_array($data)) {

			$requesst_id = $row['key1'];
 			$requesst_pass = $row['key2'];

 			$requesst_url = 'http://polza.com/app/api/payment/fondy/control/report.php';
 			$requesst_url.= '?id='.$requesst_id.'&pass='.$requesst_pass;

			echo '
				<tr>
					<td width="250px;" style="text-align:right;">'.file_get_contents($requesst_url).'.00 UAH</td>
					<td>'.$row['description'].'</td>
				</tr>
			';

		}

	?>
</table>