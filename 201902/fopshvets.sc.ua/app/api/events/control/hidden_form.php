<?

	// // Подключаем основной клас
 //    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
 //    $api = new API();

 //     // Подключаем Telegram бота
 //    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
 //    $bot = new Slack();

	// $product = $_GET['product'];

	// if (!empty($_COOKIE['email'])) {

	// 	$email = $_COOKIE['email'];

	// 	// Подключаем БД
	// 	$api->connect();

	// 	$product = $api->query(" SELECT * FROM `products` WHERE `id` = '$product' LIMIT 1 ") or die(mysql_error());

	// 	$api->add_email($email, '', '', $product['grNew'] );

	// 	$bot_text = '📬  '.$product['amoName'].' / '.$email;
	// 	$bot->say($bot_text);

	// 	header('Location: '.$product['redirect'].'');

	// }else{
		header('Location: http://polza.com/pages/kir/money-investment/form-2/');
	// }

?>