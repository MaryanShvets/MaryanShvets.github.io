<html>
<head>
	<title>Регистрации</title>

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/header.php');

	?>

</head>	
<body>

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/menu.php');
	?>

	<div id="content">

		<h1>Заявки с YouTube</h1>
		
			<?
				$api->connect();

				

				$count = $api->query(" SELECT COUNT(*) as count FROM `app_leads` WHERE `utmsourse` = 'youtube' ");
				$per_page = 10;
				$pages = ceil($count['count'] / $per_page);
				$cur_page = 1;
				if (isset($_GET['page']) && $_GET['page'] > 0) 
				{
				    $cur_page = $_GET['page'];
				}
				$start = ($cur_page - 1) * $per_page;


				
				echo '<table>';

				$data = mysql_query(" SELECT * FROM `app_leads` WHERE `utmsourse` = 'youtube' ORDER BY `app_leads`.`id`  DESC LIMIT $start, $per_page ") or die(mysql_error());
				
				while ($row = mysql_fetch_array($data)) {

					$product = $row['product'];

					$product_name = $api->query(" SELECT `amoName` FROM `products` WHERE `id` = '$product' LIMIT 1 ");

					$contact = $row['contact'];
					$contact_info = $api->query(" SELECT * FROM `app_contact` WHERE `id` = '$contact' LIMIT 1 ");

					echo '
					<tr>
						<td>'.$row['data'].' <br> '.$product_name['amoName'].'</td>
						<td>'.$contact_info['name'].' <br> '.$contact_info['email'].' <br> '.$contact_info['phone'].'</td>
						
						<td>utm_source '.$row['utmsourse'].' <br>utm_medium '.$row['utmmedium'].' <br>utm_campaigh '.$row['utmcampaing'].' <br>utm_term '.$row['utmterm'].'</td>
					</tr>';

				}

				echo '</table>';

				if($pages>2){

					if(!empty($_GET['product'])){
						$pag_pro = "&product=".$_GET['product'];
					}else{
						$pag_pro = "";
					}

					echo '<div class="pagination">';
					if ($cur_page == 1) {
						$i = $cur_page + 1;
						echo '<a href="?view=youtube'.$pag_pro.'&page='.$i.'">Следующая</a> ';
						echo '<a href="?view=youtube'.$pag_pro.'&page='.$pages.'">Конец</a> ';
					}elseif($cur_page !== 1 && $cur_page < $pages){
						$p = $cur_page - 1;
						$n = $cur_page + 1;
						echo '<a href="?view=youtube'.$pag_pro.'&page=1">Начало</a> ';
						echo '<a href="?view=youtube'.$pag_pro.'&page='.$p.'">Предыдущая</a> ';
						echo '<a href="?view=youtube'.$pag_pro.'&page='.$n.'">Следующая</a> ';
						echo '<a href="?view=youtube'.$pag_pro.'&page='.$pages.'">Конец</a> ';
					}else{
						$p = $cur_page - 1;
						echo '<a href="?view=youtube'.$pag_pro.'&page=1">Начало</a> ';
						echo '<a href="?view=youtube'.$pag_pro.'&page='.$p.'">Предыдущая</a> ';
					}
					echo '</div>';
				}

				

			?>
	</div>

</body>
</html>