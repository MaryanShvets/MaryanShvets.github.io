<?



include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

$id = $_GET['id'];

$data = mysql_query(" SELECT * FROM `app_leads` WHERE `product` = '$id' ORDER BY `app_leads`.`id`  DESC ") or die(mysql_error());

$n = 0;
while ($row = mysql_fetch_array($data)) {
	$data_array[$n]['product'] = $row['product'];
	$data_array[$n]['data'] = $row['data'];
	$data_array[$n]['utmsourse'] = $row['utmsourse'];
	$data_array[$n]['utmmedium'] = $row['utmmedium'];
	$data_array[$n]['utmcampaing'] = $row['utmcampaing'];
	$data_array[$n]['utmcontent'] = $row['utmcontent'];
	$n++;
}

echo json_encode($data_array);

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'google_get_leads', '0', '0', $id);

?>