<?

	// Этот файл принимает номер счета и создает платеж в Фонд.
	// Мы обновляем статус счета на активный и редиректим пользователя на страницу оплаты
	// Документация фонди должна быть здесь – https://portal.fondy.eu/ru/info/api/v1.0/3#chapter-3-5

	// Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

    // ini_set('display_errors', 1);

    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
    $bot = new Slack();

    // Подключаем БД
	$api->connect();

	// Готовим данные
	$invoice_id = $_GET['id'];
	$invoice_info = $api->query(" SELECT * FROM `app_payments` WHERE `id` = '$invoice_id' LIMIT 1 ");

	$fin_data = $api->get_fin('fondy');

    // Готовим данные
	$merchant_id = $fin_data['key1'];
	$merchant_pass = $fin_data['key2'];

	// Готовим данные
	$amount = $invoice_info['pay_amount'].'00'; 
	$currency = $invoice_info['pay_currency'];
	$order_id = $invoice_id.'-'.time();
	$order_desc = $invoice_info['order_desc'];
	$sender_email = $invoice_info['email'];
	$callback = 'http://polza.com/app/api/payment/fondy/control/callback.php';

	$sign_string = $merchant_pass.'|'.$amount.'|'.$currency.'|'.$merchant_id.'|'.$order_desc.'|'.$order_id.'|'.$sender_email.'|'.$callback;
	$sign=sha1($sign_string);

	// Готовим запрос
	$request = '{
	  "request": {
	    "amount": "'.$amount.'",
	    "currency": "'.$currency.'",
	    "merchant_id": "'.$merchant_id.'", 
	    "order_desc": "'.$order_desc.'",
	    "order_id": "'.$order_id.'",
	    "sender_email": "'.$sender_email.'",
	    "server_callback_url": "'.$callback.'",
	    "signature": "'.$sign.'"
	  }
	}';

	// Отправляем запрос
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://api.fondy.eu/api/checkout/url/");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$request);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = json_decode(curl_exec ($ch));
	curl_close ($ch);

	// Если все хорошо
	if($output->response->response_status=='success'){

		// Готовим данные
		$id = $_GET['order'];
		$pay_channel = 'fondy';
		$pay_id = $output->response->payment_id;
		$pay_system = '0';
		$pay_amount = $amount / 100;
		$pay_currency = $currency;
		$status = 'active';
		$card_from = '0';
		$card_type = '0';
		$card_to = $merchant_id;
		$comment = '0';
		$order_id = $_GET['order'];
		$order_desc = $comment_text;

		// Перезаписываем информацию
		$date_mod = date("Y-m-d H:i:s", strtotime('+7 hours'));
		$api->query(" UPDATE `app_payments` SET `pay_system`='$pay_system', `pay_id`='$pay_id',`status`='$status',`card_from`='$card_from',`card_type`='$card_type', `comment`='$response_description', `date_mod`='$date_mod' WHERE `id` = '$invoice_id' ");		

		// Обнуляем переменные
		unset($pay_id, $order_id, $order_desc);

		// Редирект пользователя на страницу оплаты
		header('Location: '.$output->response->checkout_url.'');
	}
	else{

		// print_r($output);

		$bot_text = '🚨 Была попытка оплатить '.$order_desc.' по счету №'.$_GET['id'].', но у Fondy что-то сламалось: '.$output->response->error_message;
		$bot->say_general($bot_text);
		$bot->say_pers('levchenkovic',$bot_text);
		$api->send_sms('У Фонди что-то сламалось. Витя, спасай', '', '0933843132');

		echo 'Что-то пошло не так. Мы уже получили уведомление об ошибке и решаем ее.';
	}

?>