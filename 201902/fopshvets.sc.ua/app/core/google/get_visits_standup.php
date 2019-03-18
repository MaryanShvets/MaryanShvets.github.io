<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

$id = $_GET['id'];

$data = mysql_query("SELECT COUNT(DISTINCT(`user`)) as `count`, `utm_source`, `utm_campaign`, `utm_content`  FROM `app_events` WHERE `date` > '2017-11-23 00:00:00' AND `url` LIKE 'http://pages.polza.com/kir/money/standup' GROUP BY `utm_source`, `utm_campaign`, `utm_content`") or die(mysql_error());

$n = 0;
while ($row = mysql_fetch_array($data)) {
	$data_array[$n]['count'] = $row['count'];
	$data_array[$n]['utm_source'] = $row['utm_source'];
	$data_array[$n]['utm_campaign'] = $row['utm_campaign'];
	$data_array[$n]['utm_content'] = $row['utm_content'];
	$n++;
}

echo json_encode($data_array);

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'google_get_visits', '0', '0', 'standup');

?>