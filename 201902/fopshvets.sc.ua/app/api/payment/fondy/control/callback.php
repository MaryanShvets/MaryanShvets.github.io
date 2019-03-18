<?

	// Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

    // Подключаем БД
	$api->connect();

    // Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
    $bot = new Slack();

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

	// Пишем боту
	$bot_text = 'пришел ответ с Фонди по счету №'.$pay_id.' со статусом '.$status.' '.$comment;
	$bot->say_test($bot_text);

	// Нормализируем данные для системы

	// Статус обработки заказа. Может содержать следующие значения:
	// created — заказ был создан, но клиент еще не ввел платежные реквизиты; необходимо продолжать опрашивать статус заказа
	// processing — заказ все еще находится в процессе обработки платежным шлюзом; необходимо продолжать опрашивать статус заказа
	// declined — заказ отклонен платежным шлюзом FONDY, внешней платежной системой или банком-эквайером
	// approved — заказ успешно совершен, средства заблокированы на счету плательщика и вскоре будут зачислены мерчанту; мерчант может оказывать услугу или “отгружать” товар
	// expired — время жизни заказа, указанное в параметре lifetime, истекло. 
	// reversed — ранее успешная транзакция была полностью или частично отменена. В таком случае параметр reversal_amount имеет не нулевое значение

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
		$api->query(" UPDATE `app_payments` SET `pay_system`='$pay_system', `status`='$status',`card_from`='$card_from',`card_type`='$card_type', `comment`='$comment', `date_mod`='$date_mod' WHERE `pay_id` = '$pay_id' ");
	}

	// Если это успешная оплата – отправляем событие для действий
	if($status == 'success'){

		// Проверяем информацию платежа
		$payment = $api->query(" SELECT * FROM `app_payments` WHERE `pay_id` = '$pay_id' LIMIT 1 ");
		
		// Если это автоматическая оплата
		if($payment['type']=='payment'){

			$bot_text = 'Зафиксирована автоматическая оплата в Fondy по выставленному счету №'.$pay_id.'. Информация передана на событие.';
			$bot->say_test($bot_text);

			$get_url = 'http://polza.com/app/api/events/control/auto_paid.php?id='.$pay_id;
			file_get_contents($get_url);
		}
		// Если это оплата инвойса
		elseif($payment['type']=='invoice'){

			$bot_text = 'Зафиксирована оплата в Fondy по выставленному счету №'.$payment['order_id'].'. Информация передана на событие.';
			$bot->say_test($bot_text);

			// Если поле с ID AmoCRM не пустой – отправляем событие
			if($payment['order_id']!=='0'){
				$get_url = 'http://polza.com/app/api/events/control/invoice_paid.php?id='.$payment['order_id'];
				file_get_contents($get_url);
			}
		}
	}elseif($status=='active'){

		$bot_text = 'сработало событие с кодом '.$comment_code;
		$bot->say_test($bot_text);

		// Проверяем информацию платежа
		$payment = $api->query(" SELECT * FROM `app_payments` WHERE `pay_id` = '$pay_id' LIMIT 1 ");

		$lead_id = $payment['order_id'];
		$lead = $api->query(" SELECT * FROM `app_leads` WHERE `id` = '$lead_id' LIMIT 1 ");

		$contact_id = $lead['contact'];
		$contact = $api->query(" SELECT * FROM `app_contact` WHERE `id` = '$contact_id' LIMIT 1 ");

		if ($comment_code=='1004') {

			$sms_text = ' по Вашей карте превышен лимит на оплаты в интернете. Для оплаты увеличьте лимит или используйте другую карту';

			$api->send_sms($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'отправили смс клиенту сообщение об ошибке '.$comment_code.' на номер '.$contact['phone'];
			$bot->say_test($bot_text);
		}
		elseif ($comment_code=='1037') {

			$sms_text = ' на Вашей карте недостаточно средств для совершения оплаты. Для оплаты пополните карту или используйте другую';

			$api->send_sms($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'отправили смс клиенту сообщение об ошибке '.$comment_code.' на номер '.$contact['phone'];
			$bot->say_test($bot_text);
		}
		elseif ($comment_code=='1003') {

			$sms_text = ' похоже, что Вы ошиблись с CVV2 кодом. Проверьте код, он на обратной стороне карты';

			$api->send_sms($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'отправили смс клиенту сообщение об ошибке '.$comment_code.' на номер '.$contact['phone'];
			$bot->say_test($bot_text);
		}
		elseif ($comment_code=='1024') {

			$sms_text = ' банк отказался проводить платеж. Возможно Вы достигли лимита по интернет-платежам. Обратитесь в поддержку банка для решения проблемы и повторите оплату.';

			$api->send_sms($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'отправили смс клиенту сообщение об ошибке '.$comment_code.' на номер '.$contact['phone'];
			$bot->say_test($bot_text);
		}
		elseif ($comment_code=='1025') {

			$sms_text = ' похоже, что Вы ошиблись со сроком действия карты или она больше не работает. Для оплаты используйте другую карту или перепроверьте дату на карте';

			$api->send_sms($sms_text, $contact['name'], $contact['phone']);

			$bot_text = 'отправили смс клиенту сообщение об ошибке '.$comment_code.' на номер '.$contact['phone'];
			$bot->say_test($bot_text);
		}else{

			$bot_text = 'Пришел ответ с кодом, которого мы не знаем. Код '.$comment_code.', ошибка '.$comment;
			$bot->say_test($bot_text);
		}
	}

	// Пример запроса

	// {
	// 	"rrn": "", 
	// 	"masked_card": 
	// 	"516874XXXXXX5601", 
	// 	"sender_cell_phone": "", 
	// 	"response_status": "success", 
	// 	"sender_account": "", "fee": "", 
	// 	"rectoken_lifetime": "", 
	// 	"reversal_amount": "0", 
	// "settlement_amount": "0", 
	// 	"actual_amount": "100", 
	// 	"order_status": "approved", 
	// 	"response_description": "",
	// 	"verification_status": "", 
	// 	"order_time": "14.02.2017 10:06:34", 
	// 	"actual_currency": "UAH", 
	// 	"order_id": "127-1487059593", 
	// 	"parent_order_id": "", 
	// 	"merchant_data": "", 
	// 	"tran_type": "purchase", 
	// 	"eci": "", 
	// 	"settlement_date": "", 
	// 	"payment_system": "p24", 
	// 	"rectoken": "", 
	// 	"approval_code": "", 
	// 	"merchant_id": 1399238,
	// 	"settlement_currency": "", 
	// 	"payment_id": 37623414, 
	// 	"product_id": "", 
	// 	"currency": "UAH",
	// 	"card_bin": 516874, 
	// 	"response_code": "", 
	// 	"card_type": "MasterCard", 
	// 	"amount": "100", 
	// 	"sender_email": "", 
	// 	"signature": "5d980bee503166600db00a7ca927fffacf0a5e66"
	// }

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

?>