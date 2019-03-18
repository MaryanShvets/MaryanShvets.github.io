<?

	session_start();
	session_write_close();

	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

	$time = Pulse::timer(false);

	MySQL::connect();

	if(!empty($_POST['title'])){
		
		$name = $_POST['title'];

		mysql_query(" INSERT INTO `app_database` ( `title`) VALUES ('$name') ");
	}

	$time = Pulse::timer($time);
	// Pulse::log($time, 'edison', 'article_new', '0', '0', '0');

?>