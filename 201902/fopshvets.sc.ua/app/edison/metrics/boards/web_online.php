<?

	ini_set('display_errors', 1);
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	API::connect();

	$old  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-60, date("Y")));
	$old = $old.' 00:00:00';

	$dashboard_lp1 = 'http://pages.polza.com/kir/money/web-online';
	$dashboard_lp2 = 'http://air.polza.com/room/web_online';
	$dashboard_product = '355';

	$date_range = array();

	for ($i=0; $i < 60; $i++) { 
		$temp = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-$i, date("Y")));
		$date_range[$temp] = 0;
	}

	$reg_all = API::query( "SELECT COUNT(DISTINCT(`contact`)) as `count` FROM `app_leads`  WHERE `product` IN('$dashboard_product') " );

?>

<div class="container dashboard">

<h1><?=$reg_all['count']?> регистраций</h1>

<div class="grid-padded">
	
	<div class="grid">
		<div class="col ">
				<div class="grid">
					<div class="col block">
						
						<?

							$chart['name'] = 'Посетители';
							$chart['label'] = 'traffic_all_history';
							$chart['height'] = '80';

							$data = mysql_query(" 
								SELECT COUNT(DISTINCT(`user`)) as `count`, date_format(`date`, \"%Y-%m-%d\") as `date`
								FROM `app_events` 
								WHERE `url` = '$dashboard_lp1' 
								AND `date` >= '$old' 
								GROUP BY date_format(`date`, \"%Y-%m-%d\")") or die(mysql_error());

							while ($row = mysql_fetch_array($data)) {

								$data_by_date[$row['date']] = $row['count'];
							}

							echo '<h3 class="ui-chart-subheader" style="margin-top: 5px;">'.$chart['name'].'</h3> <div class="chart" id="'.$chart['label'].'" style="height: '.$chart['height'].'px;"></div>';

							echo "<script type=\"text/javascript\">
							new Morris.Area({
								element: '".$chart['label']."',
								data: [";
										foreach ($date_range as $key => $value) {
											
											if( empty($data_by_date[$key]) ){
												echo "{ datetime: '".$key."',  key5:0 },";
											}
											else{
												echo "{ datetime: '".$key."',  key5:".$data_by_date[$key]." },";
											}
										}
							echo "],
								xkey: 'datetime',
								ykeys: ['key5'],
								labels: ['".$chart['name']."'],
								pointSize: 2,
								smooth:true,
								gridTextWeight:'light',
								resize:true,
								grid:false,
								continuousLine:true,
								hideHover:true,
								axes:false,
								xLabels:'day',
								lineColors:['#0f82f6']
							});</script>";
						?>

						<?

							$chart['name'] = 'Регистрации';
							$chart['label'] = 'reg_all_history';
							$chart['height'] = '80';


							$data = mysql_query(" 
							SELECT COUNT(DISTINCT(`contact`)) as `count`, date_format(`data`, \"%Y-%m-%d\") as `date`
							FROM `app_leads` 
							WHERE `product` IN('$dashboard_product')   
							AND `data`>= '$old' 
							GROUP BY date_format(`data`, \"%Y-%m-%d\")") or die(mysql_error());

							while ($row = mysql_fetch_array($data)) {

								$data_by_date[$row['date']] = $row['count'];
							}

							echo '<h3 class="ui-chart-subheader" style="margin-top: 5px;">'.$chart['name'].'</h3> <div class="chart" id="'.$chart['label'].'" style="height: '.$chart['height'].'px;"></div>';

							echo "<script type=\"text/javascript\">
							new Morris.Area({
								element: '".$chart['label']."',
								data: [";
										foreach ($date_range as $key => $value) {
											
											if( empty($data_by_date[$key]) ){
												echo "{ datetime: '".$key."',  key5:0 },";
											}
											else{
												echo "{ datetime: '".$key."',  key5:".$data_by_date[$key]." },";
											}
										}
							echo "],
								xkey: 'datetime',
								ykeys: ['key5'],
								labels: ['".$chart['name']."'],
								pointSize: 2,
								smooth:true,
								gridTextWeight:'light',
								resize:true,
								grid:false,
								continuousLine:true,
								hideHover:true,
								axes:false,
								xLabels:'day',
								lineColors:['#0f82f6']
							});</script>";
						?>

					</div>
				</div>
		</div>
		<div class="col">
				<div class="grid">
					<div class="col block">
						<div class="chart" id="funnel" style="min-height: 400px;"></div>

						<script type="text/javascript">
							Morris.Bar({
								  element: 'funnel',
								  data: [
								    { y: 'LP Page', 
								    		<?

								    			$data_visit = mysql_query( "SELECT `utm_source`, COUNT(DISTINCT(`user`)) as `count` FROM `app_events` WHERE `url` = '$dashboard_lp1' AND `date`>= '$old' GROUP BY `utm_source`" );
								    			
								    			while ($row = mysql_fetch_array($data_visit)) {

								    					echo '"'.$row['utm_source'].'":'.$row['count'].',';
								    			}	
								    		?>},
								    { y: 'Регистраций', 
								    		<?

								    			$data = mysql_query( " SELECT `utmsourse` as `utm_source`, COUNT(*) as `count` FROM `app_leads` WHERE `product` IN('$dashboard_product') AND `data`>= '$old' GROUP BY `utm_source` " );
								    			
								    			while ($row = mysql_fetch_array($data)) {

								    					echo '"'.$row['utm_source'].'":'.$row['count'].',';
								    			}	
								    		?>},
								    { y: 'Онлайн', 
								    		<?

								    			$data = mysql_query( "
															SELECT `utm_source`, COUNT(DISTINCT(`user`)) as `count` FROM `app_events` WHERE `user` IN(
																	SELECT DISTINCT(`user`)
																		FROM `app_events` 
																		WHERE `url` = '$dashboard_lp2' AND `date`>= '$old'
																)
															AND `url` = '$dashboard_lp1' AND `date`>= '$old' GROUP BY `utm_source`" );
								    			
								    			while ($row = mysql_fetch_array($data)) {

								    					echo '"'.$row['utm_source'].'":'.$row['count'].',';
								    			}	
								    		?>},
								  ],
								  xkey: 'y',
								  ykeys: [
			  							<?

			  								mysql_data_seek( $data_visit, 0 );
							    			while ($row = mysql_fetch_array($data_visit)) {
						    					echo '"'.$row['utm_source'].'",';
							    			}	
							    		?>
			  						],
								  stacked:true,
								  hideHover: 'auto',
							      behaveLikeLine: true,
							      resize: true,
			  					  labels: [
			  							<?
			  								mysql_data_seek( $data_visit, 0 );
							    			while ($row = mysql_fetch_array($data_visit)) {
						    					echo '"'.$row['utm_source'].'",';
							    			}	
							    		?>
			  						]
								});
						</script>
					</div>
				</div>
		</div>
	</div>

</div>

</div>