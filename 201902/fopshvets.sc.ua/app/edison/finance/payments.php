<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

API::connect();

?>

<div class="container">
	
	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<!-- <li onclick="aajax('finance/start', 0)" class="ajax" >Финансы</li> -->
		<li>Последние 100 платежей</li>
	</ul>

	<!-- <h1>Последние 100 платежей</h1> -->

	<br>

	<?

		$data = mysql_query(" SELECT * FROM `app_payments`ORDER BY id DESC LIMIT 100") or die(mysql_error());

		echo '<table cellspacing="0">';

		while ($row = mysql_fetch_array($data)) {

			if ($row['type']=='payment') {
				$type = 'Автооплата';
			}elseif($row['type']=='invoice'){
				$type = 'Выставленный счет';
			}

			echo '
				<tr>
					<td class="status" style="text-align:left;"><p class=" '.$row['status'].'">'.$row['status'].'</p></td>
					<td>
						<span class="pay_amount">'.number_format($row['pay_amount']).'</span>
						<span class="pay_currency">'.$row['pay_currency'].'</span>
						<span class="pay_channel">'.$row['pay_channel'].'</span>
					</td>
					<td>
						<span class="type">'.$type.'</span>
						<span class="pay_system">'.$row['pay_system'].'</span>
						<span class="pay_id">'.$row['pay_id'].'</span>
					</td>
					
					<td>
						<span class="card_from">'.$row['card_from'].'</span>
						<span class="card_type">'.$row['card_type'].'</span>
					</td>
					<td>
						<span class="order_desc">'.$row['order_desc'].'</span>
						<span class="email">'.$row['email'].'</span>
					</td>
					<td class="comment">'.$row['comment'].'</td>
					

				</tr>
			';
		}
		echo '</table>';

	?>

</div>

<style type="text/css">
table { box-shadow: 0px 0px 5px rgb(227, 227, 227); background: white; margin-bottom: 50px; border-radius: 2px; font-size: 14px; }
table tr { }
table td { padding: 10px; border-bottom: 1px solid rgb(236, 236, 236); }
.pay_amount { }
.pay_currency { }
.pay_channel { display: inline-block; width: 100%; font-size: 12px; }
.type { display: inline-block; width: 100%; }
.pay_system { font-size: 12px; }
.pay_id { font-size: 12px; }
.card_from { display: inline-block; width: 100%; text-align: center; }
.card_type { display: inline-block; width: 100%; font-size: 12px; text-align: center; }
.order_desc { }
.email { }
.comment { }
</style>