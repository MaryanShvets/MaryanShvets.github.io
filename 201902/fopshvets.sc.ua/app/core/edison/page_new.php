<?

session_start();
session_write_close();

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

if(!empty($_POST['amoName'])){

	$name = $_POST['amoName'];

	mysql_query(" INSERT INTO `products`( `amoName`, `amoTags`, `amoPrice`, `grNew`, `grEnd`, `URL`, `SmS`, `category`, `eautopay`, `user_view`, `amoview`, `grview`, `smsview`, `getCourse`, `redirect`, `redirectview`, `getCourseKey`, `getCourserXdgetId`) VALUES ('$name', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0') ");

	$time = Pulse::timer($time);
	Pulse::log($time, 'edison', 'page_new', 'ok', '0', '0');

}else{
	$time = Pulse::timer($time);
	Pulse::log($time, 'edison', 'page_new', 'empty', '0', '0');
}

?>