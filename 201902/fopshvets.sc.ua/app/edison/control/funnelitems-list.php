<div class="container database article-list">

	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<!-- <li onclick="aajax('finance/start', 0)" class="ajax" >Финансы</li> -->
		<li>Елементы воронки</li>
		<li onclick="aajax('control/funnelitems-new', 0)" class="ajax" >Добавить</li>
	</ul>

	<?

		include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

		$api = new API();
		$api->connect();
		$data = mysql_query(" SELECT * FROM `app_funnel_items` ORDER BY  `app_funnel_items`.`token` DESC   LIMIT 500 ") or die(mysql_error());

		echo '<table cellspacing="0">';
			while ($row = mysql_fetch_array($data)) {
				echo '<tr onclick="aajax(\'control/funnelitems-item\', \''.$row['token'].'\')">';
					echo '<td style="width:200px;">'.$row['id'].'</td>';
					echo '<td>'.$row['text'].'</td>';
					// echo '<td>'.$row['key1'].' <br> '.$row['key2'].'  <br> '.$row['key3'].' </td>';
				echo '</tr>';
			}
		echo '</table>';
	?>

</div>


<style type="text/css">
	table{width: 100%;margin-bottom: 50px;box-shadow: 0px 0px 5px rgb(227, 227, 227);border-radius: 2px;background: white;}
	table td{padding: 10px;border-bottom: 1px solid rgb(236, 236, 236);}
	table tr:last-child td{border-bottom: none;}
	tr:hover >td{
		background: rgb(244, 244, 244);
	}
	tr:hover{cursor: pointer;}
</style>