<?

 	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/access.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/curl.php');

    $time = Pulse::timer(false);

     // Подключаем БД
	MySQL::connect();

	$id = $_POST["WMI_PAYMENT_NO"];
	$bot_text = 'Пришел ответ с Walletone по счету №'.$id;

	echo 'WMI_RESULT=OK';

 	preg_match('/(.*?)\-/', $id, $parsed_id);

 	$id = $parsed_id[1];

 	// 	$bot_text.= ' / '.$id;

	// $bot->say_test($bot_text);

	// Проверяем информацию платежа
	$payment = MySQL::query(" SELECT * FROM `app_payments` WHERE `id` = '$id' OR `order_id` = '$id' ORDER BY  `date_create` DESC LIMIT 1 ");
	
	// Если это автоматическая оплата
	if($payment['type']=='payment'){

		$pulse['object'] = 'payment';

		// $bot_text = 'Зафиксирована автоматическая оплата в Walletone по выставленному счету №'.$id.' Информация передана на событие.';
		// $bot->say_test($bot_text);

		$lead_id = $payment['order_id'];
		$lead = MySQL::query(" SELECT * FROM `app_leads` WHERE `id` = '$lead_id' LIMIT 1 ");

		// if($lead['amo']!=='0'){
		$get_url = 'http://polza.com/app/core/events/paid_auto.php?id='.$id;
		file_get_contents($get_url);
		// }
	}
	// Если это оплата инвойса
	elseif($payment['type']=='invoice'){

		$pulse['object'] = 'invoice';

		// $bot_text = 'Зафиксирована оплата в Walletone по выставленному счету №'.$id.' Информация передана на событие.';
		// $bot->say_test($bot_text);

		// Если поле с ID AmoCRM не пустой – отправляем событие
		// if($payment['order_id']!=='0'){
		$get_url = 'http://polza.com/app/core/events/paid_invoice.php?id='.$payment['id'];
		file_get_contents($get_url);
		// }
	}

	$date_mod = date( 'Y-m-d H:i:s');
	MySQL::query(" UPDATE `app_payments` SET `status`='success', `date_mod`='$date_mod' WHERE `pay_id` = '$id' ");
	
	$time = Pulse::timer($time);
	Pulse::log($time, 'core', 'walletone_callback', 'success', $pulse['object'], $id);

?>