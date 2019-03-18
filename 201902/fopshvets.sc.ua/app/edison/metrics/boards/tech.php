

<?

	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

	API::connect();

	$money_all_currency = mysql_query(" 
	SELECT SUM(`pay_amount`) as `sum`, `pay_currency` FROM `app_payments` WHERE `order_id` IN(
	SELECT `id` FROM `app_leads` WHERE `product` IN(
				'336', '337', '338','339','340', '341'
			)
	) 
	AND `status` = 'success' GROUP BY `pay_currency`
	ORDER BY `sum`  DESC ") or die(mysql_error());

	$money_all_channel = mysql_query(" 
	SELECT COUNT(*) as `count`, `pay_channel` FROM `app_payments` WHERE `order_id` IN(
	SELECT `id` FROM `app_leads` WHERE `product` IN(
				'336', '337', '338','339','340', '341'
			)
	) 
	AND `status` = 'success' GROUP BY `pay_channel`
	ORDER BY `count`  DESC ") or die(mysql_error());

	$money_all_system = mysql_query(" 
	SELECT COUNT(*) as `count`, `pay_system` FROM `app_payments` WHERE `order_id` IN(
	SELECT `id` FROM `app_leads` WHERE `product` IN(
				'336', '337', '338','339','340', '341'
			)
	) 
	AND `status` = 'success' GROUP BY `pay_system`
	ORDER BY `count`  DESC ") or die(mysql_error());

	$money_all_status = mysql_query(" 
	SELECT COUNT(*) as `count`, `status` FROM `app_payments` WHERE `order_id` IN(
	SELECT `id` FROM `app_leads` WHERE `product` IN(
				'336', '337', '338','339','340', '341'
			)
	) 
	AND `status` != 'new' GROUP BY `status`
	ORDER BY `count`  DESC ") or die(mysql_error());

	$money_all_history = mysql_query(" 
	SELECT COUNT(1) as `count`, date_format(`date_create`, \"%Y-%m-%d\") as `date` FROM `app_payments` WHERE `order_id` IN(
	SELECT `id` FROM `app_leads` WHERE `product` IN(
			'336', '337', '338','339','340', '341'
		)
	) 
	AND `status` = 'success' GROUP BY  date_format(`date_create`, \"%Y-%m-%d\")
	ORDER BY `date`  DESC") or die(mysql_error());

	$money_all_desc = mysql_query(" SELECT * FROM `app_payments` WHERE `order_id` IN(
	SELECT `id` FROM `app_leads` WHERE `product` IN(
				'336', '337', '338','339','340', '341'
			)
	) 
	AND `status` = 'success' ORDER BY `date_create` DESC ");

	$visitors_lp = API::query( "SELECT COUNT(DISTINCT(`user`)) as `count`  FROM `app_events` WHERE `url` = 'http://pages.polza.com/kir/money/fsd'" );
	$visitors_price = API::query( "SELECT COUNT(DISTINCT(`user`)) as `count`  FROM `app_events` WHERE `url` = 'http://pages.polza.com/kir/money/fsd-price'" );
	$visitors_form = API::query( "SELECT COUNT(DISTINCT(`user`)) as `count`  FROM `app_events` WHERE `url` IN('http://polza.com/pages/form/341','http://polza.com/pages/form/340','http://polza.com/pages/form/339','http://polza.com/pages/form/338','http://polza.com/pages/form/337','http://polza.com/pages/form/336') " );
	$visitors_lead = API::query( "SELECT COUNT(DISTINCT(`contact`)) as `count`  FROM `app_leads` WHERE `product` IN('336', '337', '338','339','340', '341')  " );
	$visitors_paid = API::query( " SELECT COUNT(*)  as `count` FROM `app_payments` WHERE `order_id` IN(SELECT `id` FROM `app_leads` WHERE `product` IN('336', '337', '338','339','340', '341')) AND `status` = 'success'  " );

?>

<div class="container">

<h1>Маркетинг</h1> 

<div class="grid-padded">
	<div class="grid">
		<div class="col block">

			<div class="chart" id="funnel" style="height: 250px;"></div>

			<script type="text/javascript">
				Morris.Bar({
					  element: 'funnel',
					  data: [
					    { y: 'LP', a: <?=$visitors_lp['count']?>},
					    { y: 'Price', a: <?=$visitors_price['count']?>},
					    { y: 'Form', a: <?=$visitors_form['count']?>},
					    { y: 'Leads', a: <?=$visitors_lead['count']?>},
					    { y: 'Paid', a: <?=$visitors_paid['count']?>}
					  ],
					  xkey: 'y',
					  ykeys: ['a'],
  						labels: ['uniq']
					});
			</script>
			
		</div>
	</div>

	<!-- <div class="grid">
		<div class="col block">
			
		</div>
	</div> -->
</div>

<br><br>

<h1>Финансы</h1>

<div class="grid-padded">

	<div class="grid">

		<div class="col block col-9 ">
			<h3 class="ui-chart-subheader">Оплат</h3>
			<div class="chart" id="money_all_history" style="height: 250px;"></div>
		</div>

	</div>

	<div class="grid">

	

		<div class="col block">

			<h3 class="ui-chart-subheader">Статус</h3>

			<br>
			<div class="chart" id="money_all_status" style="height: 150px;"></div>

			<script type="text/javascript">
				new Morris.Donut({
					element: 'money_all_status',
					data: [
						<?
							while ($row = mysql_fetch_array($money_all_status)) {
								echo "{label: '".$row['status']."', value: '".$row['count']."'},";
							}	
						?>
					]
				});
			</script>

			<table>
				<?
					mysql_data_seek( $money_all_status, 0 );

					while ($row = mysql_fetch_array($money_all_status)) {
						echo "<tr><td>".number_format($row['count'])."</td><td>".$row['status']."</td></tr>";
					}
				?>
			</table>
		</div>
		

		<div class="col block">

			<h3 class="ui-chart-subheader">Валюта</h3>

			<br>
			<div class="chart" id="money_all_currency" style="height: 150px;"></div>

			<script type="text/javascript">
				new Morris.Donut({
					element: 'money_all_currency',
					data: [
						<?
							while ($row = mysql_fetch_array($money_all_currency)) {
								echo "{label: '".$row['pay_currency']."', value: '".$row['sum']."'},";
							}	
						?>
					]
				});
			</script>

			<table>
				<?
					mysql_data_seek( $money_all_currency, 0 );

					while ($row = mysql_fetch_array($money_all_currency)) {
						echo "<tr><td>".number_format($row['sum'])."</td><td>".$row['pay_currency']."</td></tr>";
					}
				?>
			</table>
		</div>

		

		<div class="col block">

			<h3 class="ui-chart-subheader">Система</h3>

			<br>
			<div class="chart" id="money_all_channel" style="height: 150px;"></div>

			<script type="text/javascript">
				new Morris.Donut({
					element: 'money_all_channel',
					data: [
						<?
							while ($row = mysql_fetch_array($money_all_channel)) {
								echo "{label: '".$row['pay_channel']."', value: '".$row['count']."'},";
							}	
						?>
					]
				});
			</script>

			<table>
				<?
					mysql_data_seek( $money_all_channel, 0 );

					while ($row = mysql_fetch_array($money_all_channel)) {
						echo "<tr><td>".number_format($row['count'])."</td><td>".$row['pay_channel']."</td></tr>";
					}
				?>
			</table>
		</div>
		

		<div class="col block">

			<h3 class="ui-chart-subheader">Способ</h3>

			<br>
			<div class="chart" id="money_all_system" style="height: 150px;"></div>

			<script type="text/javascript">
				new Morris.Donut({
					element: 'money_all_system',
					data: [
						<?
							while ($row = mysql_fetch_array($money_all_system)) {
								echo "{label: '".$row['pay_system']."', value: '".$row['count']."'},";
							}	
						?>
					]
				});
			</script>

			<table>
				<?
					mysql_data_seek( $money_all_system, 0 );

					while ($row = mysql_fetch_array($money_all_system)) {
						echo "<tr><td>".number_format($row['count'])."</td><td>".$row['pay_system']."</td></tr>";
					}
				?>
			</table>
		</div>
		

	</div>

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
	element: 'money_all_history',
	data: [
		<?
			while ($row = mysql_fetch_array($money_all_history)) {
				echo "{ datetime: '".$row['date']."',  key5:".$row['count']." },";
			}	
		?>
	],
	xkey: 'datetime',
	ykeys: ['key5'],
	labels: ['Оплат'],
	pointSize: 2,
	smooth:true,
	gridTextWeight:'light',
	resize:true,
	grid:false,
	continuousLine:true,
	hideHover:true,
	axes:false,
	xLabels:'day',
});

</script>