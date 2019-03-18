<?

if (empty($_COOKIE['affilate_user']) ) 
{
	header('Location: http://polza.com/app/affilate');
	die();
}

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

MySQL::connect();

$token = $_COOKIE['affilate_user'];
$token_info = MySQL::query(" SELECT * FROM `app_affilate_tokens` WHERE `token` = '$token' LIMIT 1 ");

if (empty($token_info['token'])) {

	header('Location: http://polza.com/app/affilate');
	die();
}

?>

<div class="container page-list">

	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<li>Продукты</li>
	</ul>

	<?

	$data = mysql_query(" SELECT * FROM `products` WHERE `category` !='aмо new lead' AND (`affilate_cost` != '0' OR `affilate_reg` != '0') ORDER BY id DESC ") or die(mysql_error());
	
	echo '<table  cellspacing="0" style="width:100%;">';

		while ($row = mysql_fetch_array($data)) {

		echo '
		<tr>
			<td>
				<span class="amoname">'.$row['amoName'].'</span>';

				if ($row['amoPrice'] >= 1) {
					echo '<span class="amotags">'.$row['amoPrice'].' рублей  / $'.$row['affilate_cost'].' </span>';
				}elseif($row['price'] >= 1){
					echo '<span class="amotags">$'.$row['price'].' / $'.$row['affilate_cost'].' ';
				}else{
					echo '<span class="amotags">Бесплатно / $'.$row['affilate_reg'].' ';
				}


			echo '</td>
			<td>';
				if($row['URL'] !== '0'){

					if (preg_match("/\?/",$row['affilate_lp'])) 
					{
						echo '<span class="url"><a target="_blank" href="'.$row['affilate_lp'].'?af='.$token_info['client_id'].'"><img src="/app/control/frontend/svg/basic_link.svg"/></a>'.$row['affilate_lp'].'&af='.$token_info['client_id'].'</span>';
					}
					else
					{
						echo '<span class="url"><a target="_blank" href="'.$row['affilate_lp'].'?af='.$token_info['client_id'].'"><img src="/app/control/frontend/svg/basic_link.svg"/></a>'.$row['affilate_lp'].'?af='.$token_info['client_id'].'</span>';
					}

				}
				if($row['redirect'] !== '0'){
					echo '<span class="redirect"><a target="_blank" href="'.$row['URL'].'"><img src="/app/control/frontend/svg/basic_link.svg"/></a>'.$row['URL'].'</span>';
				}
				
				
				echo '</td>';
			
			
		echo '</tr>';

		}

	echo '</table>';

	?>

</div>
