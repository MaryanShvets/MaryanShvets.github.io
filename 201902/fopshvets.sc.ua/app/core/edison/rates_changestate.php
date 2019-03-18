<?

ini_set('display_errors', 1);
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');

MySQL::connect();

$time = Pulse::timer(false);

$id = $_POST['id'];
$state = $_POST['state'];

mysql_query(" UPDATE `app_rates` SET `status`=$state WHERE `id` = $id LIMIT 1");

$time = Pulse::timer($time);
Pulse::log($time, 'edison', 'rates_changestate', '0', $state, $id);

?>