<?

	session_start();
	session_write_close();

	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	$api = new API();
	$api->connect();

   	$id = $_POST['id'];
   	$title = $_POST['title'];
   	$text = $_POST['text'];

   	if (!empty( $title )) {
		mysql_query( " UPDATE `app_database` SET `title`='$title' WHERE `id` = '$id' " );
   	}
   	if (!empty( $text )) {
		mysql_query( " UPDATE `app_database` SET `text`='$text' WHERE `id` = '$id' " );
   	}

   

?>