<?

// polza.com/app/core/edison/finance_income

ini_set('display_errors', 1);
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');

MySQL::connect();

$rates = Memory::load('rates');

$summ = mysql_query("SELECT SUM(`pay_amount`) as `sum`, `pay_currency` as `currency`  FROM `app_payments` WHERE `date_create` >= '2017-12-01 00:00:00' AND `status` = 'success' GROUP BY `pay_currency`");
$all_sum = 0;

while ($value = mysql_fetch_array($summ)) {

	if ($value['currency'] == 'USD') 
	{
		$all_sum = $all_sum + $value['sum'];
	}
	elseif($value['currency'] == 'UAH')
	{
		$all_sum = $all_sum + ($value['sum'] / $rates['UAH'] );
	}
	elseif($value['currency'] == 'RUB')
	{
		$all_sum = $all_sum + ($value['sum'] / $rates['RUB'] );
	}
}

echo '$'.number_format($all_sum,  0, '', ' ');
?>