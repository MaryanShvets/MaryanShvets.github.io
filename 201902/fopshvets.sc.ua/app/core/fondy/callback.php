<?

	// Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/sms.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');

    $time = Pulse::timer(false);

    MySQL::connect();

    // Читаем запрос
	$data = json_decode(file_get_contents('php://input'));

	// Готовим данные
	$pay_id = $data->payment_id;
	$pay_system = $data->payment_system;
	$status = $data->order_status;
	$card_from = $data->masked_card;
	$card_type = $data->card_type;
	$comment = $data->response_description;
	$comment_code = $data->response_code;
	
	$update_status = 1;
	
	if($status=='approved'){
		$status = 'success';
	}
	elseif($status=='created'){
		$status = 'new';
	}
	elseif($status=='processing'){
		$status = 'active';
	}
	elseif($status=='declined'){
		$status = 'declined';
	}
	elseif($status=='expired'){
		// Этот статус обозначает, что время жизни истекло.
		// Но у нас на один платеж может приходиться несколько платежей
		// Поэтому при этом статусе информацию в базе данных мы не перезаписываем
		$update_status = 0;
	}
	elseif($status=='reversed'){
		$status = 'success';
	}

	// Если информацию нужно перезаписывать – перезаписываем ее
	if($update_status == 1){

		$date_mod = date( 'Y-m-d H:i:s');
		MySQL::query(" UPDATE `app_payments` SET `pay_system`='$pay_system', `status`='$status',`card_from`='$card_from',`card_type`='$card_type', `comment`='$comment', `date_mod`='$date_mod' WHERE `pay_id` = '$pay_id' ");
	}

	// Если это успешная оплата – отправляем событие для действий
	if($status == 'success'){

		$pulse['status'] = 'success';

		// Проверяем информацию платежа
		$payment = MySQL::query(" SELECT * FROM `app_payments` WHERE `pay_id` = '$pay_id' LIMIT 1 ");
		
		// Если это автоматическая оплата
		if($payment['type']=='payment'){

			$pulse['object'] = 'payment';
			$pulse['id'] = $pay_id;

			$bot_text = 'Зафиксирована автоматическая оплата в Fondy по выставленному счету №'.$pay_id.'. Информация передана на событие.';
			// $bot->say_test($bot_text);

			$get_url = 'http://polza.com/app/core/events/paid_auto.php?id='.$pay_id;
			file_get_contents($get_url);
		}
		// Если это оплата инвойса
		elseif($payment['type']=='invoice'){

			$pulse['object'] = 'invoice';
			$pulse['id'] = $payment['order_id'];

			$bot_text = 'Зафиксирована оплата в Fondy по выставленному счету №'.$payment['pay_id'].'. Информация передана на событие.';
			// $bot->say_test($bot_text);

			// Если поле с ID AmoCRM не пустой – отправляем событие
			// if($payment['order_id']!=='0'){
			$get_url = 'http://polza.com/app/core/events/paid_invoice.php?id='.$payment['id'];
			file_get_contents($get_url);
			// }
		}
		
	}elseif($status=='active'){

		$pulse['status'] = 'active';

		$bot_text = 'сработало событие с кодом '.$comment_code;
		// $bot->say_test($bot_text);

		// Проверяем информацию платежа
		$payment = MySQL::query(" SELECT * FROM `app_payments` WHERE `pay_id` = '$pay_id' LIMIT 1 ");

		$lead_id = $payment['order_id'];
		$lead = MySQL::query(" SELECT * FROM `app_leads` WHERE `id` = '$lead_id' LIMIT 1 ");

		$contact_id = $lead['contact'];
		$contact = MySQL::query(" SELECT * FROM `app_contact` WHERE `id` = '$contact_id' LIMIT 1 ");

		if ($comment_code=='1004') {

			$sms_text = ' по Вашей карте превышен лимит на оплаты в интернете. Для оплаты увеличьте лимит или используйте другую карту';

			SMS::send($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'отправили смс клиенту сообщение об ошибке '.$comment_code.' на номер '.$contact['phone'];
			// $bot->say_test($bot_text);
			$pulse['object'] = $comment_code;
			$pulse['id'] = $lead_id;
		}
		elseif ($comment_code=='1037') {

			$sms_text = ' на Вашей карте недостаточно средств для совершения оплаты. Для оплаты пополните карту или используйте другую';

			SMS::send($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'отправили смс клиенту сообщение об ошибке '.$comment_code.' на номер '.$contact['phone'];
			// $bot->say_test($bot_text);
			$pulse['object'] = $comment_code;
			$pulse['id'] = $lead_id;
		}
		elseif ($comment_code=='1003') {

			$sms_text = ' похоже, что Вы ошиблись с CVV2 кодом. Проверьте код, он на обратной стороне карты';

			SMS::send($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'отправили смс клиенту сообщение об ошибке '.$comment_code.' на номер '.$contact['phone'];
			// $bot->say_test($bot_text);
			$pulse['object'] = $comment_code;
			$pulse['id'] = $lead_id;
		}
		elseif ($comment_code=='1024') {

			$sms_text = ' банк отказался проводить платеж. Возможно Вы достигли лимита по интернет-платежам. Обратитесь в поддержку банка для решения проблемы и повторите оплату.';

			SMS::send($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'отправили смс клиенту сообщение об ошибке '.$comment_code.' на номер '.$contact['phone'];
			// $bot->say_test($bot_text);
			$pulse['object'] = $comment_code;
			$pulse['id'] = $lead_id;
		}
		elseif ($comment_code=='1025') {

			$sms_text = ' похоже, что Вы ошиблись со сроком действия карты или она больше не работает. Для оплаты используйте другую карту или перепроверьте дату на карте';

			SMS::send($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'отправили смс клиенту сообщение об ошибке '.$comment_code.' на номер '.$contact['phone'];
			// $bot->say_test($bot_text);
			$pulse['object'] = $comment_code;
			$pulse['id'] = $lead_id;
		}
		elseif ($comment_code=='1051') {

			$sms_text = ' банк не разрешает транзакцию, потому что считает ее подозрительной. Мы уже увидили эту проблему и пытаемся ее решить.';

			SMS::send($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'отправили смс клиенту сообщение об ошибке с антифродом на номер '.$contact['phone'].' - клиент ждет нашей помощи';
			// $bot->say_test($bot_text);
			$pulse['object'] = $comment_code;
			$pulse['id'] = $lead_id;
		}
		elseif ($comment_code=='1048') {

			$sms_text = ' возникла проблема с вашим платежем. Мы уже пытаемся ее решить.';

			SMS::send($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'У нас проблема с лимитом платежей по клиенту '.$contact['phone'];
			// $bot->say_test($bot_text);
			$pulse['object'] = $comment_code;
			$pulse['id'] = $lead_id;
		}else{

			$bot_text = 'Пришел ответ с кодом, которого мы не знаем. Код '.$comment_code.', ошибка '.$comment;
			// $bot->say_test($bot_text);
			$pulse['object'] = 'notfound';
			$pulse['id'] = $lead_id;

		}

		Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));
	}

	$time = Pulse::timer($time);
	Pulse::log($time, 'core', 'fondy_callback', $pulse['status'], $pulse['object'], $pulse['id']);

?>