<?

	$data = mysql_query(" SELECT * FROM `app_payments`ORDER BY id DESC LIMIT 100") or die(mysql_error());

	echo '<table>';

	while ($row = mysql_fetch_array($data)) {

		echo '
			<tr>
				<td class="status" style="text-align:left;"><p class=" '.$row['status'].'">'.$row['status'].'</p></td>
				<td>
					<span class="pay_amount">'.number_format($row['pay_amount']).'</span>
					<span class="pay_currency">'.$row['pay_currency'].'</span>
					<span class="pay_channel">'.$row['pay_channel'].'</span>
				</td>
				<td>
					<span class="type">'.$row['type'].'</span>
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