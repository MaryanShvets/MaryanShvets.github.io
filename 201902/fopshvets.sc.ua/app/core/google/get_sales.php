<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

$id = $_GET['product'];
$utm_source = $_GET['utm_source'];


$data = mysql_query(" SELECT * FROM `app_payments` WHERE `order_id` IN(SELECT `id` FROM `app_leads` WHERE `product` = '$id') ") or die(mysql_error());

$n = 0;
while ($row = mysql_fetch_array($data)) {
	$data_array[$n]['id'] = $row['id'];
	$data_array[$n]['status'] = $row['status'];
	$data_array[$n]['comment'] = $row['comment'];
	$data_array[$n]['order_desc'] = $row['order_desc'];
	$data_array[$n]['date_mod'] = $row['date_mod'];
	$n++;
}


echo json_encode($data_array);

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'google_get_sales', '0', $utm_source, $id);

?>