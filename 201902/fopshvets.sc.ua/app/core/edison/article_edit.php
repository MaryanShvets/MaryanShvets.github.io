<?

session_start();
session_write_close();

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

$id = $_POST['id'];
$title = $_POST['title'];
$text = $_POST['text'];

if (!empty( $title )) {

	mysql_query( " UPDATE `app_database` SET `title`='$title' WHERE `id` = '$id' " );
}
if (!empty( $text )) {
	
	mysql_query( " UPDATE `app_database` SET `text`='$text' WHERE `id` = '$id' " );
}

$time = Pulse::timer($time);

?>