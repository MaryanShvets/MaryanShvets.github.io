<html>
<head>
	<title>Финансы</title>

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/header.php');

	?>

</head>	
<body class="page-finance">

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/menu.php');
	?>

	<div id="content">

		<h1>Финансы</h1>

		<ul id="status">
			<li><a <?if(empty($_GET['status'])){echo 'class="active"';}?> href="/app/control/?view=finance">Платежи</a></li>
			<!-- <li><a <?if($_GET['status']=='privat'){echo 'class="active"';}?> href="/app/control/?view=finance&status=privat">Приват24</a></li> -->
			<li><a <?if($_GET['status']=='setting'){echo 'class="active"';}?> href="/app/control/?view=finance&status=setting">Настройки</a></li>
		</ul>

			<?
				
				$api->connect();

				if(empty($_GET['status'])){
					$data = mysql_query(" SELECT * FROM `app_payments`ORDER BY id DESC ") or die(mysql_error());

					echo '<table>';

					while ($row = mysql_fetch_array($data)) {

						echo '
							<tr>
								<td class="status" style="text-align:left;"><p class=" '.$row['status'].'">'.$row['status'].'</p></td>
								<td>
									<span class="pay_amount">'.number_format($row['pay_amount']).'</span>
									<span class="pay_currency">'.$row['pay_currency'].'</span>
									<span class="pay_channel">'.$row['pay_channel'].'</span>
								</td>
								<td>
									<span class="type">'.$row['type'].'</span>
									<span class="pay_system">'.$row['pay_system'].'</span>
									<span class="pay_id">'.$row['pay_id'].'</span>
								</td>
								
								<td>
									<span class="card_from">'.$row['card_from'].'</span>
									<span class="card_type">'.$row['card_type'].'</span>
								</td>
								<td>
									<span class="order_desc">'.$row['order_desc'].'</span>
									<span class="email">'.$row['email'].'</span>
								</td>
								<td class="comment">'.$row['comment'].'</td>
								

							</tr>
						';
					}
					echo '</table>';
				}elseif($_GET['status']=='privat'){
					
					echo '<table id="result" class="privat">';

						echo '
							<div id="loading">
								<div class="cssload-container">
									<div class="cssload-whirlpool"></div>
								</div>

								<p>Выгружаем платежи</p>
							</div>
						';

					echo '</table>';

					echo '
						<script type="text/javascript">
							$(\'document\').ready(function(){
								$(\'#loading\').fadeIn();

								$.ajax({
						           type: "POST",
						           url: \'/app/api/privatbank/control/get_payments.php\',
						           success: function(data)
						           {
						           		$(\'#result\').html(data);
						           		$(\'#loading\').fadeOut();
						           }
							         }).done(function() {
							         	$(\'#result\').html(data);
						           		$(\'#loading\').fadeOut();
									});
							});
						</script>
					';
				}elseif($_GET['status']=='setting'){

					echo '
						<br>
						<p id="info">❗️ Информация внизу используется в работе платежных систем.</p>
					';

					$data = json_decode(file_get_contents('http://polza.com/app/api/payment/config.json'));

					echo '<form id="form-fin" style="margin-left: 25px; margin-right:25px;margin-top:25px; background: #ececec; display: inline-block; padding: 10px; border-radius: 3px;">';
					foreach ($data as $key => $value) {
						echo '<div style="display: inline-block; margin: 10px; box-sizing: border-box; width: 98%;">';
			        	echo '<span>'.$key.'</span><br>';
			        	echo '<input style="width:100%;" type="text" name="'.$key.'" id="'.$key.'" value="'.$value.'">';
			        	echo '</div>';
					}
					echo '</form>';
					echo '<br><div id="submit" style="margin-top: 25px;margin-left: 25px;" class="mb-60 btn green">Отправить</div><br><br>';

					echo '
						<div id="loading">
							<div class="cssload-container">
								<div class="cssload-whirlpool"></div>
							</div>

							<p>Сохраняем изменения</p>
						</div>
					';

					echo '
						<script type="text/javascript">
							$(document).ready(function() { 
								$(\'#submit\').click(function(){

									$(\'#loading\').fadeIn();

									 $.ajax({
							           type: "POST",
							           url: \'http://polza.com/app/control/api/control/post_config.php\',
							           data: $("#form-fin").serialize(),
							           success: function(data)
							           {
							           }
								         }).done(function() {
										  $(\'#loading\').fadeOut();
										});
								});
							});
						</script>
					';
				}

			?>
	</div>
</body>
</html>