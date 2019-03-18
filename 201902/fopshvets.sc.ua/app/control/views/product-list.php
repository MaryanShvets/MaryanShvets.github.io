<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Страницы</title>

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/header.php');

	?>

</head>	
<body class="page-product-list">

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/menu.php');
	?>

	<div id="content">

		<h1>Страницы <a href="http://polza.com/app/control/?view=product-new">Создать страницу</a></h1>

		<table>

			<?
				
				$api->connect();

				$count = $api->query(" SELECT COUNT(*) as count FROM `products` WHERE `category` !='aмо new lead' ");
				$per_page = 50;
				$pages = ceil($count['count'] / $per_page);
				$cur_page = 1;
				if (isset($_GET['page']) && $_GET['page'] > 0) 
				{
				    $cur_page = $_GET['page'];
				}
				$start = ($cur_page - 1) * $per_page;

				$data = mysql_query(" SELECT * FROM `products` WHERE `category` !='aмо new lead' ORDER BY id DESC LIMIT $start, $per_page") or die(mysql_error());

				
				echo '<table>';
				while ($row = mysql_fetch_array($data)) {

					echo '
					<tr>
						<td><a href="/app/control?view=product-edit&id='.$row['id'].'"><img src="/app/control/frontend/svg/basic_gear.svg"/></a></td>
						<td><a href="/app/control?view=submits&product='.$row['id'].'"><img src="/app/control/frontend/svg/basic_archive_full.svg"/></a></td>
						<td>
							<span class="amoname">'.$row['amoName'].'</span>';

							if( $row['amoPrice']>=1 ){
								echo '<span class="amotags">'.$row['amoPrice'].' рублей ';
							}
							else{
								echo '<span class="amotags">';
							}

							if( $row['amoTags']!=='0' ){
								echo ' '.$row['amoTags'].'</span>';
							}else{
								echo '</span>';
							}

						echo '</td>
						<td>';

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
							echo '<td class="amoview"><img src="/app/control/frontend/svg/basic_headset-active.svg"/></td>';
						}else{
							echo '<td class="amoview"><img src="/app/control/frontend/svg/basic_headset.svg"/></td>';
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
						
					echo '</tr>';
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
						echo '<a href="?view=product-list&page='.$i.'">Следующая</a> ';
						echo '<a href="?view=product-list&page='.$pages.'">Конец</a> ';
					}elseif($cur_page !== 1 && $cur_page < $pages){
						$p = $cur_page - 1;
						$n = $cur_page + 1;
						echo '<a href="?view=product-list&page=1">Начало</a> ';
						echo '<a href="?view=product-list&page='.$p.'">Предыдущая</a> ';
						echo '<a href="?view=product-list&page='.$n.'">Следующая</a> ';
						echo '<a href="?view=product-list&page='.$pages.'">Конец</a> ';
					}else{
						$p = $cur_page - 1;
						echo '<a href="?view=product-list&page=1">Начало</a> ';
						echo '<a href="?view=product-list&page='.$p.'">Предыдущая</a> ';
					}
					echo '</div>';
				}

			?>
		</table>
	</div>

</body>
</html>