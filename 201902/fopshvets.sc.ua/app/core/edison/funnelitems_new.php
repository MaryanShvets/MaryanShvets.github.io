<?

session_start();
session_write_close();

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

if(!empty($_POST['id'])){

	$name = $_POST['id'];

	mysql_query(" INSERT INTO `app_funnel_items`( `id`) VALUES ('$name') ");

	$time = Pulse::timer($time);
	Pulse::log($time, 'edison', 'funnelitems_new', 'ok', '0', '0');

}else{
	$time = Pulse::timer($time);
	Pulse::log($time, 'edison', 'funnelitems_new', 'empty', '0', '0');
}

?>