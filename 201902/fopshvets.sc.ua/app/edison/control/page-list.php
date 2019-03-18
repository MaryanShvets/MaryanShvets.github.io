<div class="container page-list">

	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<li>Страницы</li>
		<li onclick="aajax('control/page-new', 0)" class="ajax" >Создать</li>
	</ul>

	<?

	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

	$api = new API();
	$api->connect();
	$data = mysql_query(" SELECT * FROM `products` WHERE `category` != 'aмо new lead' AND category != 'old page' ORDER BY id DESC ") or die(mysql_error());
	
	echo '<table  cellspacing="0">';

		while ($row = mysql_fetch_array($data)) {

		echo '
		<tr>
			<td onclick="aajax(\'control/page-edit\', \''.$row['id'].'\')"><a ><img src="/app/control/frontend/svg/basic_gear.svg"/></a></td>
			<td>
				<span class="amoname">'.$row['amoName'].'</span>';


				if ($row['amoPrice'] >= 1) {
					echo '<span class="amotags">'.$row['amoPrice'].' рублей </span>';
				}elseif($row['price'] >= 1){
					echo '<span class="amotags">$'.$row['price'].' ';
				}else{
					echo '<span class="amotags">Бесплатно';
				}


				
				// if( $row['amoPrice']>=1 ){
				// echo '<span class="amotags">'.$row['amoPrice'].' рублей ';
				// 	}
				// 	else{
				// 	echo '<span class="amotags">';
				// 		}
				// 		if( $row['amoTags']!=='0' ){
				// 	echo ' '.$row['amoTags'].'</span>';
				// 	}else{
				// echo '</span>';
				// }

			echo '</td>';

			echo '<td style="width:150px;">';
				if ($row['affilate_cost'] !== '0') 
				{
					echo '<span class="affilate_cost">Продажа $'.$row['affilate_cost'].'</span>';
				}
				
				if($row['affilate_reg'] !== '0')
				{
					echo '<span class="affilate_reg">Регистрация $'.$row['affilate_reg'].'</span>';
				}

			echo '</td>';

			echo '<td>';
				if($row['URL'] !== '0'){
					echo '<span class="url"><a target="_blank" href="'.$row['URL'].'"><img src="/app/control/frontend/svg/basic_link.svg"/></a>'.$row['URL'].'</span>';
				}
				if($row['redirect'] !== '0'){
					echo '<span class="redirect"><a target="_blank" href="'.$row['redirect'].'"><img src="/app/control/frontend/svg/basic_link.svg"/></a>'.$row['redirect'].'</span>';
				}
				if($row['redirectPay'] !== '0'){
					echo '<span class="redirect"><a target="_blank" href="'.$row['redirectPay'].'"><img src="/app/control/frontend/svg/basic_link.svg"/></a>'.$row['redirectPay'].'</span>';
				}
				
				echo '</td>';
			if ($row['amoview']=='1') {
			echo '<td class="amoview"><img src="/app/control/frontend/svg/basic_money_active.svg"/></td>';
			}else{
				echo '<td class="amoview"><img src="/app/control/frontend/svg/basic_money.svg"/></td>';
			}
			if ($row['grview']=='1') {
				echo '<td class="grview"><img src="/app/control/frontend/svg/basic_mail_multiple-active.svg"/></td>';
			}else{
				echo '<td class="grview"><img src="/app/control/frontend/svg/basic_mail_multiple.svg"/></td>';
			}
			if ($row['smsview']=='1') {
				echo '<td class="smsview"><img src="/app/control/frontend/svg/basic_smartphone-active.svg"/></td>';
			}else{
				echo '<td class="smsview"><img src="/app/control/frontend/svg/basic_smartphone.svg"/></td>';
			}
			if ($row['LMSview']=='1') {
				echo '<td class="smsview"><img src="/app/control/frontend/svg/basic_book_pencil-active.svg"/></td>';
			}else{
				echo '<td class="smsview"><img src="/app/control/frontend/svg/basic_book_pencil.svg"/></td>';
			}
			
		echo '</tr>';

		}

	echo '</table>';

	?>

</div>