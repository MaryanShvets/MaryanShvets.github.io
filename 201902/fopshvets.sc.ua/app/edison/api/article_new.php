<?

	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	$api = new API();
	$api->connect();


	if(!empty($_POST['title'])){
		
		$name = $_POST['title'];

		mysql_query(" INSERT INTO `app_database` ( `title`) VALUES ('$name') ");
	}

?>