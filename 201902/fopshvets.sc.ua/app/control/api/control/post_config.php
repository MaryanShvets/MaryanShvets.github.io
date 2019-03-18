<?

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 1);

	// Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/telegram/class.php');
    $bot = new Telegram();

	$file = "/app/api/payment/config.json";
	$file = "/home/kirgkybv/public_html/polza.com/app/api/payment/config.json";

	$json = array(
		'fondy_merchant' => $_POST['fondy_merchant'],
		'fondy_pass' => $_POST['fondy_pass'],
		'p24_card' => $_POST['p24_card'],
		'p24_id' => $_POST['p24_id'],
		'p24_pass' => $_POST['p24_pass'],
		'wallet_merchant' => $_POST['wallet_merchant'],
		'wallet_key' => $_POST['wallet_key'],
		'yandex_card' => $_POST['yandex_card']
	);

	file_put_contents($file, json_encode($json));

	$bot_text = 'Финансовые настройки были обновлены на '.json_encode($json);
    $bot->say_test($bot_text);

?>