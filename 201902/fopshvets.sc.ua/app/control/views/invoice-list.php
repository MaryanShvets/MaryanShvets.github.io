<html>
<head>
	<title>Все счета</title>

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/header.php');

	?>

	

</head>	
<body class="page-invoice-list">

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/menu.php');
	?>

	<div id="content">

		

		<h1>Все счета <a href="http://polza.com/app/control/?view=invoice-new">Создать счет</a></h1>

		<ul id="status">
			<li><a <?if(empty($_GET['status'])){echo 'class="active"';}?> href="/app/control/?view=invoice-list">Все</a></li>
			<li><a <?if($_GET['status']=='new'){echo 'class="active"';}?> href="/app/control/?view=invoice-list&status=new">Новые</a></li>
			<li><a <?if($_GET['status']=='active'){echo 'class="active"';}?> href="/app/control/?view=invoice-list&status=active">Активные</a></li>
			<li><a <?if($_GET['status']=='success'){echo 'class="active"';}?> href="/app/control/?view=invoice-list&status=success">Успешные</a></li>
		</ul>

		<table>

			<?


				$status = $_GET['status'];

				if (empty($status)) {
					$api->connect();
					$data = mysql_query(" SELECT * FROM `app_payments` WHERE `type` = 'invoice' ORDER BY id DESC  LIMIT 100 ") or die(mysql_error());
				}else{
					$api->connect();
					$data = mysql_query(" SELECT * FROM `app_payments` WHERE `type` = 'invoice' AND `status` = '$status' ORDER BY id DESC  LIMIT 100 ") or die(mysql_error());
				}
				
				
				while ($row = mysql_fetch_array($data)) {
					echo '
					<tr>
						<td class="pay_system">
						<button class="btn-clipboard" data-clipboard-text="http://polza.com/app/api/payment/'.$row['pay_channel'].'/control/invoice.php?id='.$row['id'].'"></button>
						</td>
						
						<td>
							<span class="pay_amount">'.number_format($row['pay_amount']).'</span>
							<span class="pay_currency">'.$row['pay_currency'].'</span><br>
							<span class="pay_channel">'.$row['pay_channel'].'</span>
						</td>

						<td>
							<span class="order_desc">'.$row['order_desc'].'</span>
							<span class="email">'.$row['email'].'</span>
						</td>
						<td class="comment">'.$row['comment'].'</td>
						<td class="status"><p class="label '.$row['status'].'">'.$row['status'].'</p></td>

					</tr>';
				}

			?>
		</table>

		<div id="submit" class="btn help green">Подсказка</div>

		<p id="info" style="display: none;">Сверху все инвойсы, которые выставил Отдел Пользы. Мы в системе будем их називать «Счетами».
		Чтобы выставить счет на оплату клиенту нажми на кнопку «Создать отчет» и заполни всю информацию.<br>
		p.s. для начала протестируй на себе, чтобы понять, как это будет видеть клиент.
		<br>
		<br>
		По статусам счетов:<br>
		<strong>new</strong> – новый счет<br>
		<strong>active</strong> – активный счет, а это значит клиент начал оплату<br>
		<strong>success</strong> – клиент оплатил счет
		</p>
	</div>

	<div id="loading">
		<p style="font-size: 24px;">Ссылка на счет скопирована. Просто вышли ее клиенту</p>
	</div>

	<script src="https://cdn.rawgit.com/zenorocha/clipboard.js/master/dist/clipboard.min.js"></script>

	<script type="text/javascript">
		new Clipboard('.btn-clipboard');
	</script>
	<script type="text/javascript">
		$('document').ready(function(){
			$('#submit').click(function(){
				$('#submit').fadeOut();
				$('#info').fadeIn();
			});

			$('.btn-clipboard').click(function(){
				$('#loading').fadeIn();
				$('#loading').delay(3000).fadeOut(400)
			});
			
		});

		

	</script>
</body>
</html>