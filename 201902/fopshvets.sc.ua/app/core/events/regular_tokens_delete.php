<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');

$time = Pulse::timer(false);

MySQL::connect();

$last_hour = date("Y-m-d h:m:s", strtotime('-1 hours'));

mysql_query(" DELETE FROM `app_affilate_tokens` WHERE `date_create` <= '$last_hour' ");

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_regular_tokens_delete', '0', '0', '0');
// polza.com/app/core/events/regular_tokens_delete

?>