<?

session_start();
session_write_close();

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

$id = $_POST['id'];
$type = $_POST['type'];
$status = $_POST['status'];


if ($type == 'aprove' && $status == 'no') 
{
	$next_status = 1;
}
elseif($type == 'aprove' && $status == 'yes')
{
	$next_status = 2;
}
elseif($type == 'paid' && $status == 'no')
{
	$next_status = 2;
}
elseif($type == 'paid' && $status == 'yes')
{
	$next_status = 3;
}

// 0 - не перевірено
// 1 - не підтверджений
// 2 - підтверджений
// 3 - виплачено
// 4 - відхилено

$mysql = " UPDATE `app_affilate_payments` SET `status`= $next_status WHERE `id` = $id ";
mysql_query($mysql) or die(mysql_error());

$time = Pulse::timer($time);
Pulse::log($time, 'edison', 'finance_affilate_status', $type, $status, $id);



?>