<?

session_start();
session_write_close();

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

if(!empty($_POST['description'])){

	$name = $_POST['description'];

	mysql_query(" INSERT INTO `app_payments_config`( `description`) VALUES ('$name') ");

	$time = Pulse::timer($time);
	Pulse::log($time, 'edison', 'finance_config_new', 'ok', '0', '0');

}else{
	$time = Pulse::timer($time);
	Pulse::log($time, 'edison', 'finance_config_new', 'empty', '0', '0');
}

?>