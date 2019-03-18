<?

	// Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

     // Подключаем БД
	$api->connect();

	// Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
    $bot = new Slack();

	$id = $_POST["WMI_PAYMENT_NO"];
	$bot_text = 'Пришел ответ с Walletone по счету №'.$id;

	echo 'WMI_RESULT=OK';

 	preg_match('/(.*?)\-/', $id, $parsed_id);

 	$id = $parsed_id[1];

 	$bot_text.= ' / '.$id;

	$bot->say_test($bot_text);

	// Проверяем информацию платежа
	$payment = $api->query(" SELECT * FROM `app_payments` WHERE `id` = '$id' OR `order_id` = '$id' ORDER BY  `date_create` DESC LIMIT 1 ");
	
	// Если это автоматическая оплата
	if($payment['type']=='payment'){

		$bot_text = 'Зафиксирована автоматическая оплата в Walletone по выставленному счету №'.$id.' Информация передана на событие.';
		$bot->say_test($bot_text);

		$lead_id = $payment['order_id'];
		$lead = $api->query(" SELECT * FROM `app_leads` WHERE `id` = '$lead_id' LIMIT 1 ");

		if($lead['amo']!=='0'){
			$get_url = 'http://polza.com/app/api/events/control/auto_paid.php?id='.$id;
			file_get_contents($get_url);
		}
	}
	// Если это оплата инвойса
	elseif($payment['type']=='invoice'){

		$bot_text = 'Зафиксирована оплата в Walletone по выставленному счету №'.$id.' Информация передана на событие.';
		$bot->say_test($bot_text);

		// Если поле с ID AmoCRM не пустой – отправляем событие
		if($payment['order_id']!=='0'){
			$get_url = 'http://polza.com/app/api/events/control/invoice_paid.php?id='.$payment['order_id'];
			file_get_contents($get_url);
		}
	}

	$date_mod = date( 'Y-m-d H:i:s');
	$api->query(" UPDATE `app_payments` SET `status`='success', `date_mod`='$date_mod' WHERE `pay_id` = '$id' ");
	 

	// Структура БД – app_payments

	// `pay_channel`, 
	// `pay_id`, 
	// `pay_system`, 
	// `pay_amount`, 
	// `pay_currency`, 
	// `status`, 
	// `card_from`,
	// `card_type`, 
	// `card_to`, 
	// `comment`, 
	// `order_id`,
	// `order_desc`
	// `date_create`
	// `date_mod`

	// include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	// $api = new API();
	// $api->connect();

	// $id= $_GET['id'];
	// $id= '61814';
	
	// $data = file_get_contents('php://input');

	// Получение дополнительной информации по платежу
	// $lead = $api->query(" SELECT `contact` FROM `app_leads` WHERE `id` = '$id' LIMIT 1 ");
	// $contact_id = $lead['contact'];
	// $contact = $api->query(" SELECT * FROM `app_contact` WHERE `id` = '$contact_id' LIMIT 1 ");
	// $name = $contact['name'];
	// $email = $contact['email'];
	// $phone = $contact['phone'];
	// $product_id = $lead['product'];
	// $product = $api->query(" SELECT * FROM `products` WHERE `id` = '$product_id' LIMIT 1 ");

	// $comment_text = 'Платеж по продукту '.$product['amoName'].' от клиента '.$name.' '.$phone.' '.$email;

	// Конвертируем суму
	// $data->amount = $data->amount / 100;

	// Присваеваем переменным их значения
	// $pay_channel = 'fondy';
	// $pay_id = $data->payment_id;
	// $pay_system = $data->payment_system;
	// $pay_amount = $data->amount;
	// $pay_currency = $data->currency;
	// $status = $data->response_status;
	// $card_from = $data->masked_card;
	// $card_type = $data->card_type;
	// $card_to = $data->merchant_id;
	// $comment = $data->response_description;
	// $order_id = $id;
	// $order_desc = $comment_text;


	// $api->query(" INSERT INTO `app_payments`( `pay_channel`, `pay_id`, `pay_system`, `pay_amount`, `pay_currency`, `status`, `card_from`, `card_type`, `card_to`, `comment`, `order_id`, `order_desc`) VALUES ('$pay_channel', '$pay_id', '$pay_system', '$pay_amount', '$pay_currency', '$status', '$card_from', '$card_type', '$card_to', '$comment', '$order_id', '$order_desc' ) ");

	// $fp = fopen('callback.txt', 'a');
	// fwrite($fp, $data . PHP_EOL);
	// fclose($fp);

?>