<?

	ini_set('display_errors', 1);

	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

	API::connect();

	$old  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-60, date("Y")));

	$old = $old.' 00:00:00';

	$date_range = array();

	for ($i=0; $i < 60; $i++) { 
		
		$temp = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-$i, date("Y")));
		$date_range[$temp] = 0;
	}

	$money_people_history = mysql_query(" 
	SELECT COUNT(1) as `count`, date_format(`date_create`, \"%Y-%m-%d\") as `date` FROM `app_payments` WHERE `order_id` IN(
	SELECT `id` FROM `app_leads` WHERE `product` IN(
			'342', '343', '344', '345', '346'
		)
	) 
	AND `status` = 'success' AND `date_create` >= '$old' GROUP BY  date_format(`date_create`, \"%Y-%m-%d\")
	ORDER BY `date`  DESC") or die(mysql_error());

	while ($row = mysql_fetch_array($money_people_history)) {
		$paid_history[$row['date']] = $row['count'];
	}	

	$money_all_currency = mysql_query(" 
	SELECT SUM(`pay_amount`) as `sum`, `pay_currency`, date_format(`date_create`, \"%Y-%m-%d\") as `date` FROM `app_payments` WHERE `order_id` IN(
	SELECT `id` FROM `app_leads` WHERE `product` IN(
				'342', '343', '344', '345', '346'
			)
	) 
	AND `status` = 'success'  AND `date_create` >= '$old'  GROUP BY `pay_currency`, date_format(`date_create`, \"%Y-%m-%d\")
	ORDER BY `sum`  DESC ") or die(mysql_error());

	while ($row = mysql_fetch_array($money_all_currency)) {

		if ($row['pay_currency'] == 'UAH') {
			
			$money_uah[$row['date']] = $row['sum'];

		}elseif($row['pay_currency'] == 'RUB'){

			$money_rub[$row['date']] = $row['sum'];

		}elseif($row['pay_currency'] == 'USD'){

			$money_usd[$row['date']] = $row['sum'];
		}
		
	}	

	foreach ($date_range as $key => $value) {

		$sum = $money_usd[$key];

		if (!empty( $money_uah[$key] )) {
			$sum = $sum + $money_uah[$key] / 26.3;
		}

		if (!empty( $money_rub[$key] )) {
			$sum = $sum + $money_rub[$key] / 57.9;
		}

		$money_all[$key] = round($sum);
	}

	$money_all_history = mysql_query(" 
	SELECT SUM(`pay_amount`) as `sum`, `pay_currency` FROM `app_payments` WHERE `order_id` IN(
	SELECT `id` FROM `app_leads` WHERE `product` IN(
				'342', '343', '344'
			)
	) 
	AND `status` = 'success'  AND `date_create` >= '$old'  GROUP BY `pay_currency`
	ORDER BY `sum`  DESC ") or die(mysql_error());

	$traffic_all_history = mysql_query(" 
		SELECT COUNT(DISTINCT(`user`)) as `count`, date_format(`date`, \"%Y-%m-%d\") as `date`
		FROM `app_events` 
		WHERE `url` = 'http://pages.polza.com/kir/money/fsd-week' 
		AND `date` >= '$old' 
		GROUP BY date_format(`date`, \"%Y-%m-%d\")") or die(mysql_error());

	while ($row = mysql_fetch_array($traffic_all_history)) {

		$traffic_history[$row['date']] = $row['count'];
	}


	$lead_all_history = mysql_query(" 
		SELECT COUNT(DISTINCT(`contact`)) as `count`, date_format(`data`, \"%Y-%m-%d\") as `date`
		FROM `app_leads` 
		WHERE `product` IN('342', '343', '344', '345', '346')   
		AND `data`>= '$old' 
		GROUP BY date_format(`data`, \"%Y-%m-%d\")") or die(mysql_error());

	while ($row = mysql_fetch_array($lead_all_history)) {

		$lead_history[$row['date']] = $row['count'];
	}


	$visitors_lp = API::query( "SELECT COUNT(DISTINCT(`user`)) as `count`  FROM `app_events` WHERE `url` = 'http://pages.polza.com/kir/money/fsd-week' AND `date`>= '$old'  " );
	$visitors_price = API::query( "SELECT COUNT(DISTINCT(`user`)) as `count`  FROM `app_events` WHERE `url` = 'http://pages.polza.com/kir/money/fsd-week-price' AND `date`>= '$old'  " );
	$visitors_form = API::query( "SELECT COUNT(DISTINCT(`user`)) as `count`  FROM `app_events` WHERE `url` IN('http://polza.com/pages/form/342','http://polza.com/pages/form/343','http://polza.com/pages/form/344')  AND `date`>= '$old' " );
	$visitors_lead = API::query( "SELECT COUNT(DISTINCT(`contact`)) as `count`  FROM `app_leads` WHERE `product` IN('342', '343', '344')   AND `data`>= '$old'  " );
	$visitors_paid = API::query( " SELECT COUNT(*)  as `count` FROM `app_payments` WHERE `order_id` IN(SELECT `id` FROM `app_leads` WHERE `product` IN('342', '343', '344', '345', '346')) AND `status` = 'success'   AND `date_create`>= '$old'  " );

	$visitors_lp_funnel = mysql_query( "SELECT `utm_source`, COUNT(DISTINCT(`user`)) as `count` FROM `app_events` WHERE `url` = 'http://pages.polza.com/kir/money/fsd-week' AND `date`>= '$old' GROUP BY `utm_source`" );

	$visitors_form_funnel = mysql_query( "
			SELECT `utm_source`, COUNT(DISTINCT(`user`)) as `count` FROM `app_events` WHERE `user` IN(
					SELECT `user`  
						FROM `app_events` 
						WHERE 
							`url` IN (
									'http://polza.com/pages/form/342',
									'http://polza.com/pages/form/343',
									'http://polza.com/pages/form/344'
								)
				)
			AND `url` = 'http://pages.polza.com/kir/money/fsd-week' AND `date`>= '$old' GROUP BY `utm_source`" );

	$visitors_price_funnel = mysql_query( "
			SELECT `utm_source`, COUNT(DISTINCT(`user`)) as `count` FROM `app_events` WHERE `user` IN(
					SELECT `user`
						FROM `app_events` 
						WHERE `url` = 'http://pages.polza.com/kir/money/fsd-week-price' AND `date`>= '$old'
				)
			AND `url` = 'http://pages.polza.com/kir/money/fsd-week' AND `date`>= '$old' GROUP BY `utm_source`" );

	$visitors_lead_funnel = mysql_query(" SELECT `utmsourse` as `utm_source`, COUNT(*) as `count` FROM `app_leads` WHERE `product` IN('342', '343', '344') AND `data`>= '$old' GROUP BY `utm_source` ");

	$visitors_paid_funnel = mysql_query("
		SELECT `utmsourse` as `utm_source`, COUNT(*) as `count` FROM `app_leads` WHERE `id` IN(
			SELECT `order_id` FROM `app_payments` WHERE `order_id` IN(SELECT `id` FROM `app_leads` WHERE `product` IN('342', '343', '344')) AND `status` = 'success'   AND `date_create`>= '$old'
		) GROUP BY `utm_source`
	");

	$money_all_desc = mysql_query(" SELECT * FROM `app_payments` WHERE `order_id` IN(
	SELECT `id` FROM `app_leads` WHERE `product` IN(
				'342', '343', '344', '345', '346'
			)
	) 
	AND `status` = 'success' AND `date_create`>= '$old' ORDER BY `date_create` DESC ");

	$summ = 0;

	mysql_data_seek( $money_all_currency, 0 );

	while ($row = mysql_fetch_array($money_all_currency)) {
		$count = $row['sum'];
		$pay_currency = $row['pay_currency'];

		if ($pay_currency == 'USD') {
			$summ = $summ + $count;
		}elseif($pay_currency == 'UAH'){

			$count = $count / 26.3;
			$summ = $summ + $count;

		}elseif($pay_currency == 'RUB'){

			$count = $count / 57.9;
			$summ = $summ + $count;
		}
	}

?>



<div class="container dashboard">

<h1><?=$visitors_paid['count']?> участников, $<?=number_format($summ);?></h1>

<div class="grid-padded">
	
	<div class="grid">

		<div class="col">
				<div class="grid">

				<div class="col block col-9 ">

					<h3 class="ui-chart-subheader" style="margin-top: 5px;">Посетители</h3>
					<div class="chart" id="traffic_all_history" style="height: 80px;"></div>

					<h3 class="ui-chart-subheader" style="margin-top: 5px;">Лиды</h3>
					<div class="chart" id="leads_all_history" style="height: 80px;"></div>

					<h3 class="ui-chart-subheader" style="margin-top: 5px;">Оплаты</h3>
					<div class="chart" id="people_all_history" style="height: 80px;"></div>

					<h3 class="ui-chart-subheader" style="margin-top: 5px;">Выручка</h3>
					<div class="chart" id="money_all_history" style="height: 80px;"></div>
				</div>

			</div>
		</div>

		<div class="col">
			<div class="grid">
		<div class="col block">

			<div class="chart" id="funnel" style="min-height: 400px;"></div>
			<!-- <div id="stacked" ></div> -->

			<script type="text/javascript">
				Morris.Bar({
					  element: 'funnel',
					  data: [
					    { y: 'LP Page', 
					    		<?
					    			while ($row = mysql_fetch_array($visitors_lp_funnel)) {
					    				// if ($row['utm_source']!=='0') {
					    					echo '"'.$row['utm_source'].'":'.$row['count'].',';
					    				// }
					    			}	
					    		?>},
					    { y: 'LP Price', 
					    		<?
					    			while ($row = mysql_fetch_array($visitors_price_funnel)) {
					    				// if ($row['utm_source']!=='0') {
					    					echo '"'.$row['utm_source'].'":'.$row['count'].',';
					    				// }
					    			}	
					    		?>},
					    { y: 'LP Form', 
					    		<?
					    			while ($row = mysql_fetch_array($visitors_form_funnel)) {
					    				// if ($row['utm_source']!=='0') {
					    					echo '"'.$row['utm_source'].'":'.$row['count'].',';
					    				// }
					    			}	
					    		?>},
					     { y: 'Лиды', 
					    		<?
					    			while ($row = mysql_fetch_array($visitors_lead_funnel)) {
					    				// if ($row['utm_source']!=='0') {
					    					echo '"'.$row['utm_source'].'":'.$row['count'].',';
					    				// }
					    			}	
					    		?>},
					    { y: 'Оплаты', 
					    		<?
					    			while ($row = mysql_fetch_array($visitors_paid_funnel)) {
					    				// if ($row['utm_source']!=='0') {
					    					echo '"'.$row['utm_source'].'":'.$row['count'].',';
					    				// }
					    			}	
					    		?>},
					  ],
					  xkey: 'y',
					  ykeys: [
  							<?
  								mysql_data_seek( $visitors_lp_funnel, 0 );
				    			while ($row = mysql_fetch_array($visitors_lp_funnel)) {
			    					// if ($row['utm_source']!=='0') {
				    					echo '"'.$row['utm_source'].'",';
				    				// }
				    			}	
				    		?>
  						],
					  stacked:true,
					  hideHover: 'auto',
				      behaveLikeLine: true,
				      resize: true,
  					  labels: [
  							<?
  								mysql_data_seek( $visitors_lp_funnel, 0 );
				    			while ($row = mysql_fetch_array($visitors_lp_funnel)) {

				    				// if ($row['utm_source']!=='0') {
				    					echo '"'.$row['utm_source'].'",';
				    				// }
				    				
				    			}	
				    		?>
  						]
					});

				// $("#funnel").click(function(e) {
			 //    var pathCol  = this.nextSibling.getAttribute("stroke");     
		  //       $(".morris-hover-point").each(function() {       
		  //           var labStyle = this.getAttribute("style");
		  //           var labCol = labStyle.slice(labStyle.indexOf(":")+1);           
		  //           if(pathCol.trim().toLowerCase() === labCol.trim().toLowerCase()) {
		  //               console.log("You have Clicked On: "+this.textContent);
		  //           }           
		  //       });        
			 // });

				function getClickedValue(event) {
		        var pathCol  = this.nextSibling.getAttribute("stroke");     
		        $(".morris-hover-point").each(function() {       
		            var labStyle = this.getAttribute("style");
		            var labCol = labStyle.slice(labStyle.indexOf(":")+1);           
		            if(pathCol.trim().toLowerCase() === labCol.trim().toLowerCase()) {
		                console.log("You have Clicked On: "+this.textContent);
		            }           
		        });     
		    }
		    $(document).on('click', 'path', getClickedValue); 
			</script>
			
			<div class="chart-tools">
				<?
						mysql_data_seek( $visitors_lp_funnel, 0 );
	    			while ($row = mysql_fetch_array($visitors_lp_funnel)) {

	    				// if ($row['utm_source']!=='0') {
	    				echo ' <a onclick="" style="text-transform:none;" class="item ajax btn">'.$row['utm_source'].' ('.$row['count'].')</a> ';
	    					// echo '"'.$row['utm_source'].'",';
	    				// }
	    				
	    			}	
	    		?>
			</div>

		</div>
	</div>
		</div>

	</div>

</div>

<div class="grid-padded">



	
 
	

	<div class="grid">
		<div class="col block">
			<table class="border">
				<?
					while ($row = mysql_fetch_array($money_all_desc)) {
						echo "<tr><td>".$row['date_create']."</td><td>".$row['pay_amount']."</td><td>".$row['pay_currency']."</td><td>".$row['order_desc']."</td></tr>";
					}
				?>
			</table>
		</div>
	</div>

</div>

</div>

<script type="text/javascript">

new Morris.Area({
	element: 'traffic_all_history',
	data: [
		<?

			foreach ($date_range as $key => $value) {
				
				if( empty($traffic_history[$key]) ){
					echo "{ datetime: '".$key."',  key5:0 },";
				}
				else{
					echo "{ datetime: '".$key."',  key5:".$traffic_history[$key]." },";
				}
			}
			
		?>
	],
	xkey: 'datetime',
	ykeys: ['key5'],
	labels: ['Посетителей'],
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
});

new Morris.Area({
	element: 'leads_all_history',
	data: [
		<?

			foreach ($date_range as $key => $value) {
				
				if( empty($lead_history[$key]) ){
					echo "{ datetime: '".$key."',  key5:0 },";
				}
				else{
					echo "{ datetime: '".$key."',  key5:".$lead_history[$key]." },";
				}
			}
			
		?>
	],
	xkey: 'datetime',
	ykeys: ['key5'],
	labels: ['Лиды'],
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
});

new Morris.Area({
	element: 'people_all_history',
	data: [
		<?

			foreach ($date_range as $key => $value) {
				
				if( empty($paid_history[$key]) ){
					echo "{ datetime: '".$key."',  key5:0 },";
				}
				else{
					echo "{ datetime: '".$key."',  key5:".$paid_history[$key]." },";
				}
			}
			
		?>
	],
	xkey: 'datetime',
	ykeys: ['key5'],
	labels: ['Оплаты'],
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
});

new Morris.Area({
	element: 'money_all_history',
	data: [
		<?

			foreach ($date_range as $key => $value) {
				
				if( empty($money_all[$key]) ){
					echo "{ datetime: '".$key."',  key5:0 },";
				}
				else{
					echo "{ datetime: '".$key."',  key5:".$money_all[$key]." },";
				}
			}
			
		?>
	],
	xkey: 'datetime',
	ykeys: ['key5'],
	labels: ['Выручка'],
	pointSize: 2,
	smooth:true,
	gridTextWeight:'light',
	resize:true,
	grid:false,
	continuousLine:true,
	hideHover:true,
	axes:false,
	preUnits:'$',
	lineColors:['#0f82f6']
});

</script>