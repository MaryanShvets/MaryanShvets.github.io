<div class="container">

	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<li>События</li>
		<li onclick="aajax('metrics/system-list', 0)" class="ajax" >Обновить</li>
	</ul>

	<?

	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

	$api = new API();
	$api->connect();

	?>


	<?
		$data = mysql_query(" SELECT * FROM `app_pulse` ORDER BY `datetime` DESC  LIMIT 500 ") or die(mysql_error());
		
		echo '<table cellspacing="0">';
			while ($row = mysql_fetch_array($data)) {
				echo '<tr onclick="aajax_system(\''.$row['time'].'\', \''.$row['key1'].'\', \''.$row['key2'].'\', \''.$row['key3'].'\', \''.$row['key4'].'\', \''.$row['key5'].'\')">';
					echo '<td>'.$row['datetime'].'</td>';

					if ($row['time'] > 2.5) {
						echo '<td style="color:red;">'.$row['time'].'</td>';
					}else{
						echo '<td style="color:green;">'.$row['time'].'</td>';
					}
					
					echo '<td>'.$row['key1'].'</td>';
					echo '<td>'.$row['key2'].'</td>';
					echo '<td>'.$row['key3'].'</td>';
					echo '<td>'.$row['key4'].'</td>';
					echo '<td>'.$row['key5'].'</td>';
				echo '</tr>';
			}
		echo '</table>';

	?>
</div>

<div id="modal_system">
	<div id="modal_system_inside">
		<div id="modal_system_head">
			<span onclick="modal_system_close()">Закрыть</span>
		</div>
		<div id="modal_system_content">
			<div id="modal_loading"><div class="cssload-container"><ul class="cssload-flex-container"><li><span class="cssload-loading"></span></li></div></div></div>
		</div>
	</div>
</div>

<style type="text/css">
	table{width: 100%;margin-bottom: 50px;box-shadow: 0px 0px 5px rgb(227, 227, 227);border-radius: 2px;background: rgb(255, 255, 255);font-size: 14px;}
	table td{padding: 10px;border-bottom: 1px solid rgb(236, 236, 236);}
	table tr:last-child td{border-bottom: none;}
	table tr:hover{cursor: pointer;}
	tr:hover >td{background: rgb(244, 244, 244);}
</style>