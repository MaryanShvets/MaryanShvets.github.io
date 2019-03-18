<table>

	<?
		
		$data = mysql_query(" SELECT * FROM `app_payments_config` LIMIT 500 ") or die(mysql_error());
		
		while ($row = mysql_fetch_array($data)) {

			echo '
				<tr>
					<td>'.$row['id'].'</td>
					<td>'.$row['status'].'</td>
					<td>'.$row['system'].'</td>
					<td>'.$row['description'].'</td>
				</tr>
			';
			
			// echo '
			// <tr>
			// 	<td class="pay_system">
			// 	<button class="btn-clipboard" data-clipboard-text="http://polza.com/app/api/payment/'.$row['pay_channel'].'/control/invoice.php?id='.$row['id'].'"></button>
			// 	</td>
				
			// 	<td>
			// 		<span class="pay_amount">'.number_format($row['pay_amount']).'</span>
			// 		<span class="pay_currency">'.$row['pay_currency'].'</span><br>
			// 		<span class="pay_channel">'.$row['pay_channel'].'</span>
			// 	</td>

			// 	<td>
			// 		<span class="order_desc">'.$row['order_desc'].'</span>
			// 		<span class="email">'.$row['email'].'</span>
			// 	</td>
			// 	<td class="comment">'.$row['comment'].'</td>
			// 	<td class="status"><p class="label '.$row['status'].'">'.$row['status'].'</p></td>

			// </tr>';
		}

	?>
</table>