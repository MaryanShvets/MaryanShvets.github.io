<?

	// Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/telegram/class.php');
    $bot = new Telegram();

    // Получем текст
	$text = $_GET['text'];

	// Отправляем в дебаг режиме
	$bot->say_test($text);
	
?>