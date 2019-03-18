<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

API::connect();

?>

<div class="container">
	
	<?

		$page_count = 100;
		$page_curent = $_GET['param'];
		$page_curent = $page_curent + 0;

		if (!empty($_COOKIE['filter_affilatepayment'])) 
		{
			$sql_filter = " AND `affilate` = ".$_COOKIE['filter_affilatepayment'];

			echo '<h2>Платежи партнера '.$_COOKIE['filter_affilatepayment'].' // <a onclick="aajax_filter_affilatepayment_open();" style="color:#0f82f6;">Фильтр</a></h2><br><br>';
		}
		else
		{
			$sql_filter = "";

			echo '<h2>Все платежи // <a onclick="aajax_filter_affilatepayment_open();" style="color:#0f82f6;">Фильтр</a></h2><br><br>';
		}

		if (empty($page_curent)) 
		{
			$page_curent = 1;
			$start_from = 0;
		}
		else
		{
			$start_from = $page_curent * $page_count - $page_count;
		}
		

		$data = mysql_query(" SELECT * FROM `app_affilate_payments` WHERE `status` != '0' $sql_filter ORDER BY id DESC LIMIT $start_from, $page_count") or die(mysql_error());

		echo '<table cellspacing="0" >';

		while ($row = mysql_fetch_array($data)) {

			if ($row['type']=='reg') {
				$type = 'Регистрация';
			}elseif($row['type']=='pay'){
				$type = 'Продажа';
			}

			if ($row['status'] == 1) 
			{
				$control_div = '
					<span onclick="aajax_affilate_status('.$row['id'].', \'aprove\')" id="affilate_control_aprove_'.$row['id'].'" data-status="no" class="action_aprove" >👥❌</span> 
					<span onclick="aajax_affilate_status('.$row['id'].', \'paid\')" data-status="block" id="affilate_control_paid_'.$row['id'].'" class="action_paid block">💰❌</span>
				';
			}
			elseif($row['status'] == 2)
			{
				$control_div = '
					<span onclick="aajax_affilate_status('.$row['id'].', \'aprove\')" id="affilate_control_aprove_'.$row['id'].'" data-status="yes" class="action_aprove" >👥✅</span> 
					<span onclick="aajax_affilate_status('.$row['id'].', \'paid\')" data-status="no" id="affilate_control_paid_'.$row['id'].'" class="action_paid">💰❌</span>
				';	
			}
			elseif($row['status'] == 3)
			{
				$control_div = '
					<span onclick="aajax_affilate_status('.$row['id'].', \'aprove\')" id="affilate_control_aprove_'.$row['id'].'" data-status="yes" class="action_aprove" >👥✅</span> 
					<span onclick="aajax_affilate_status('.$row['id'].', \'paid\')" data-status="yes" id="affilate_control_paid_'.$row['id'].'" class="action_paid">💰✅</span>
				';	
			}

			echo '
				<tr>
					<td>
						<span class="datetime">'.$row['date_event'].' </span> 
					</td>

					<td>
						<span class="pay_currency">'.$row['amount'].' '.$row['currency'].'</span>
						<br>
						<span class="type">'.$type.' </span> 
					</td>

					<td>
						<span class="product_name">'.$row['product_name'].'</span>
					</td>
					
					<td>
						<span class="affilate">Партнер '.$row['affilate'].'</span>
						<br>
						<span class="sub_id">Заявка '.$row['sub_id'].'</span>
					</td>

					<td style="width:300px;">
						<span class="info" onclick="aajax_affilate_info('.$row['id'].');">ℹ️</span>
						'.$control_div.'
					</td>
					
					
				</tr>
			';
		}
		echo '</table>';

		$pagination_count = API::query(" SELECT COUNT(*) as `count` FROM `app_affilate_payments` WHERE `status` != '0' $sql_filter ");
		$pagination_count = $pagination_count['count'];
		$pagination_pages = ceil($pagination_count / $page_count);

		if ($pagination_pages > 1) 
		{
			if ($page_curent >= 3) {
				echo '<span class="pagination" onclick="aajax(\'finance/affilate-payments\', 1)">Первая – 1</span>';
				echo '<span class="pagination" onclick="aajax(\'finance/affilate-payments\', '.($page_curent - 1).')">Назад – '. ($page_curent - 1) .'</span>';
			}
			elseif($page_curent == 2)
			{
				echo '<span class="pagination" onclick="aajax(\'finance/affilate-payments\', 1)">Первая – 1</span>';
			}


			echo '<span class="pagination active">Текущая – '.$page_curent.'</span>';

			if ($page_curent <= ($pagination_pages - 1)) {

				echo '<span class="pagination" onclick="aajax(\'finance/affilate-payments\', '.($page_curent + 1).')">Дальше – '. ($page_curent + 1) .'</span>';
			}

			if ($page_curent != $pagination_pages) {
				echo '<span class="pagination"  onclick="aajax(\'finance/affilate-payments\', '.$pagination_pages.')"> Последняя – '.$pagination_pages.'</span>';
			}
		}

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
table { box-shadow: 0px 0px 5px rgb(227, 227, 227); background: white; margin-bottom: 50px; border-radius: 2px; font-size: 14px; width:100%; }
table tr { }
table td { padding: 10px; border-bottom: 1px solid rgb(236, 236, 236); }
.pay_amount { }
.pay_currency { }
.pay_channel { display: inline-block; width: 100%; font-size: 12px; }
.type { display: inline-block; width: 100%; }
.pay_system { font-size: 12px; }
.pay_id { font-size: 12px; }
.card_from { display: inline-block; width: 100%; text-align: center; }
.card_type { display: inline-block; width: 100%; font-size: 12px; text-align: center; }
.order_desc { }
.email { }
.comment { }
.action_paid,
.action_aprove,
.info,
.pagination{
	transition: all 0.5s;
	margin: 5px;
	box-shadow: 0px 0px 5px rgb(227, 227, 227);
	border: 1px solid white;
	padding: 10px 20px;
	margin-right: 10px;
	display: inline-block;
	box-sizing: border-box;
	text-align: left;
	background: white;
}
.action_paid:hover,
.action_aprove:hover,
.info:hover,
.pagination:hover{
	cursor: pointer;
	box-shadow: 0px 0px 10px rgb(158, 158, 158);

}
.action_paid.not,
.action_aprove.not{
	color:red;
}
.action_paid.yes,
.action_aprove.yes{
	color:green;
}
.action_paid.block{
	cursor: block;
	opacity: 0.3;
}
.action_paid.block:hover{
	box-shadow: 0px 0px 5px rgb(227, 227, 227);
	cursor: block;
}

.pagination{
	border-radius: 10px;
}
.pagination.active{
	color: #0f82f6;
	font-weight: 400;
}
.pagination.active:hover{
	cursor: initial;;
}

</style>