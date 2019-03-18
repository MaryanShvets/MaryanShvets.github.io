<?

	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	$api = new API();
	$api->connect();

	// Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/telegram/class.php');
    $bot = new Telegram();
	

	if(!empty($_POST['amoName'])){
		$name = $_POST['amoName'];

		$bot_text = 'Создана страница '.$name;
    	$bot->say_test($bot_text);

		mysql_query(" INSERT INTO `products`( `amoName`, `amoTags`, `amoPrice`, `grNew`, `grEnd`, `URL`, `SmS`, `category`, `eautopay`, `user_view`, `amoview`, `grview`, `smsview`, `getCourse`, `redirect`, `redirectview`, `getCourseKey`, `getCourserXdgetId`) VALUES ('$name', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0') ");
	}

?>