<?

if (empty($_COOKIE['affilate_user']) ) 
{
	header('Location: http://polza.com/app/affilate');
	die();
}

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

MySQL::connect();

$token = $_COOKIE['affilate_user'];
$token_info = MySQL::query(" SELECT * FROM `app_affilate_tokens` WHERE `token` = '$token' LIMIT 1 ");

$affilate_id=$token_info['client_id'];


$notconfirmed_sum = 0;
$notconfirmed_count = 0;
$notpaid_sum = 0;
$notpaid_count = 0;

$sum_data = mysql_query("SELECT SUM(`amount`) as `amount`, COUNT(*) as `count`, `status` FROM `app_affilate_payments` WHERE `affilate` = $affilate_id GROUP BY `status`");


while ($value = mysql_fetch_array($sum_data)) {

	if ($value['status'] == '1') {
		
		$notconfirmed_sum = $notconfirmed_sum + $value['amount'];
		$notconfirmed_count = $value['count'];
	}
	elseif ($value['status'] == '2') {
		
		$notpaid_sum = $notpaid_sum + $value['amount'];
		$notpaid_count = $value['count'];
	}

}

?>

<div class="container">

<? echo '<h2>Неподтвержденных: $'.round($notconfirmed_sum, 2).' ('.$notconfirmed_count.') Невыплаченных: $'.round($notpaid_sum, 2).' ('.$notpaid_count.')</h2'; ?>


<div class="grid-padded">
				<div class="grid">

					<div class="col col-4">
						<p class="sub-header" style="font-size: 18px;padding-left: 5px;color: grey;">Главное меню</p>
						<ul style="padding-left:0px;">
							<li class="item ajax btn" onclick="aajax('control/product_list', 0)" >🗄 &nbsp; &nbsp;Список продуктов</li>
							<li class="item ajax btn" onclick="aajax('control/leads_list', 1)" >👥 &nbsp; &nbsp;Конверсии</li>
							<a href="http://polza.com/4affiliate" target="_blank"><li class="item ajax btn"  >🎓 &nbsp; &nbsp;Материалы для партнеров</li></a>
						</ul>
					</div>

					<div class="col col-8">
						<p class="sub-header" style="font-size: 18px;padding-left: 5px;color: grey;">Последние события</p>
						<ul style="padding-left:0px;">

							<?

								$data = mysql_query(" SELECT * FROM `app_affilate_payments` WHERE `status` != '0' AND `affilate` = $affilate_id ORDER BY id DESC LIMIT 20") or die(mysql_error());

								$n = 0;
								while ($row = mysql_fetch_array($data)) 
								{
									echo '<li onclick="aajax(\'control/leads_list\', 1)" class="item ajax btn" >'.$row['date_event'].' // '.$row['amount'].' '.$row['currency'].' // '.$row['product_name'].'</li>';
									$n++;
								}

								if ($n==0) {
									echo '<li  class="item ajax btn" >Конверсий пока что нету</li>';
								}
							?>
						</ul>
					</div> 
					
				</div>
			</div>


</div>

<style type="text/css">
	.btn{display: block;margin-bottom: 10px;}
	a .btn{
		border: 1px solid white;
	}
	a .btn:hover{
		cursor: pointer;
color: #0f82f6;
border: 1px solid #0f82f6;
	}
</style>