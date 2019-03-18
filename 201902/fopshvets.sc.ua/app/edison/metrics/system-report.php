<div class="container">

	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<li>Система</li>
		<li onclick="aajax('metrics/system-report', 0)" class="ajax" >Обновить</li>
	</ul>

	<?

	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
	MySQL::connect();

	$yesterday = date("Y-m-d", strtotime('+6 hours'));
	$yesterday = date("Y-m-d", strtotime('-1 days'));
	$yesterday = $yesterday.' 00:00:01';

	$today = date("Y-m-d", strtotime('+6 hours'));
	$today = $today.' 00:00:01';

	
	$yesterday = mysql_query(" SELECT `key2` as `service`, COUNT(*) as `count`, ROUND(AVG(`time`),2) as `time`  FROM `app_pulse` WHERE `datetime` >= '$yesterday' AND `datetime` <'$today' AND `key2` !='events' GROUP BY `service` ORDER BY `count`  DESC ");
	$today = mysql_query(" SELECT `key2` as `service`, COUNT(*) as `count`, ROUND(AVG(`time`),2) as `time`  FROM `app_pulse` WHERE `datetime` >= '$today' AND `key2` !='events' GROUP BY `service` ORDER BY `count`  DESC ");

	?>

	<br>

	<h1>Сегодня</h1>
	
	<br>

	<?

	while ($row = mysql_fetch_array($today)) {

		echo '<div class="report_item">';
			echo '<span class="service">'.$row['service'].'</span>';
			echo '<span class="count" >'.$row['count'].'</span> / ';

			if ($row['time'] > 2) {
				echo '<span class="time bad">'.$row['time'].'</span>';
			}else{
				echo '<span class="time good">'.$row['time'].'</span>';
			}
			
		echo '</div>';

	}

	?>

	<br>

	<h1>Вчера</h1>

	<br>

	<?

	while ($row = mysql_fetch_array($yesterday)) {

		echo '<div class="report_item">';
			echo '<span class="service">'.$row['service'].'</span>';
			echo '<span class="count" >'.$row['count'].'</span> / ';

			if ($row['time'] > 2) {
				echo '<span class="time bad">'.$row['time'].'</span>';
			}else{
				echo '<span class="time good">'.$row['time'].'</span>';
			}
			
		echo '</div>';

	}

	?>

	
</div>

<style type="text/css">
	.report_item{box-shadow: 0px 0px 5px rgb(227, 227, 227);
padding: 10px;
margin-bottom: 15px;
border-radius: 2px;
width: 30%;
margin-right: 15px;
display: inline-block;
box-sizing: border-box;
text-align: center;
background: white;}
	.report_item .service{display: inline-block;
width: 100%;
font-size: 24px;
margin-top: 10px;
margin-bottom: 10px;
font-weight: 300;}
	.report_item .count{}
	.report_item .time{}
	.report_item .time.good{color:#2bd717;}
	.report_item .time.bad{color:#d74d49;}
</style>

<!-- <div id="modal_system">
	<div id="modal_system_inside">
		<div id="modal_system_head">
			<span onclick="modal_system_close()">Закрыть</span>
		</div>
		<div id="modal_system_content">
			<div id="modal_loading"><div class="cssload-container"><ul class="cssload-flex-container"><li><span class="cssload-loading"></span></li></div></div></div>
		</div>
	</div>
</div> -->

<!-- <style type="text/css">
	table{width: 100%;margin-bottom: 50px;box-shadow: 0px 0px 5px rgb(227, 227, 227);border-radius: 2px;background: rgb(255, 255, 255);}
	table td{padding: 20px;border-bottom: 1px solid rgb(236, 236, 236);}
	table tr:last-child td{border-bottom: none;}
	table tr:hover{cursor: pointer;}
	tr:hover >td{background: rgb(244, 244, 244);}
</style> -->