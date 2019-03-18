<?

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 1);

	// Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

    $time = $api->pulse_timer(false);

    // Подключаем БД
	$api->connect();

    // Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
    $bot = new Slack();

    // Подключаем набор функций с AmoCRM
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/control/basic.php');

    // Получаем ID оплаты
	$pay_id = $_GET['id'];

	$bot_text = 'замечена автооплата №'.$pay_id;
    $bot->say_test($bot_text);

	// Проверяем информацию платежа
	$payment = $api->query(" SELECT * FROM `app_payments` WHERE `pay_id` = '$pay_id' LIMIT 1 ");

	// Если это автоматическая оплата
	if($payment['type']=='payment'){

		// Получаем информацию про заявку, контакт и продукт
		$lead_id = $payment['order_id'];
		$lead = $api->query(" SELECT * FROM `app_leads` WHERE `id` = '$lead_id' LIMIT 1 ");

		$contact_id = $lead['contact'];
		$contact = $api->query(" SELECT * FROM `app_contact` WHERE `id` = '$contact_id' LIMIT 1 ");

		$product_id = $lead['product'];
		$product = $api->query(" SELECT * FROM `products` WHERE `id` = '$product_id' LIMIT 1 ");

		$bot_text = 'Автооплата №'.$lead['amo'].' ('.$product['amoName'].', '.$payment['pay_amount'].' '.$payment['pay_currency'].')';
		$bot_text_more = $payment['order_desc'];
		
		$bot->say_pers('oleksandr.roshchyn', $bot_text);
		$bot->say_pers('oleksandr.roshchyn', $bot_text_more);
		$bot->say_pers('rtf',$bot_text);
		$bot->say_pers('rtf',$bot_text_more);
		$bot->say_pers('levchenkovic',$bot_text);
		$bot->say_pers('levchenkovic',$bot_text_more);

        $bot_text = '💰 '.$product['amoName'].' / '.$payment['pay_amount'].' '.$payment['pay_currency'].' / '.$contact['email'];
        $bot->say($bot_text);

		// Если мы знаем куда переводить в емейлах
		if ($product['grEnd'] !== '0') {

			$api->add_email($contact['email'], $contact['name'], $contact['phone'], $product['grEnd'] );

			$bot_text = 'почта '.$contact['email'].' добавлена в список '.$product['grEnd'].' ActiveCampaign';
    		$bot->say_test($bot_text);
		}

		// Если мы знаем куда переводить в АнтиТренинг
		if ($product['LMSview'] == '1') {

			$contact['email'] = urlencode($contact['email']);
			$product['LMScode'] = urlencode($product['LMScode']);
			$product['LMSkey'] = urlencode($product['LMSkey']);
			$contact['name'] = urlencode($contact['name']);

			$bot_text = 'отправляю задачу в АнтиТренги ('.$product['LMScode'].', '.$product['LMSkey'].') '.$contact['email'].'';
		    $bot->say_test($bot_text);

			$site = 'http://polza.com/app/api/antitreningi/control/member.php';
			$site.= '?email='.$contact['email'].'&integration_id='.$product['LMScode'].'&secret='.$product['LMSkey'].'&first_name='.$contact['name'].'&status=active';

			file_get_contents($site);

		}

		// Если заявка попала в AmoCRM
		if ($lead['amo'] !== '0') {

			$get_url = 'http://polza.com/app/api/amocrm/control/paid_lead.php?id='.$lead_id;
			file_get_contents($get_url);

			$note_text = 'Оплата в системе '.$payment['pay_channel'].' на сумму '.$payment['pay_amount'].'('.$payment['pay_currency'].')';
			amo_add_note('TYPE_LEAD', 'COMMON', $note_text, $lead['amo']);

		    $bot_text = 'сменен статус в заявке №'.$lead['amo'].' Амо и добавлена заметка про оплату';
		    $bot->say_test($bot_text);
		}
	}

	$time = $api->pulse_timer($time);
	$api->pulse_log($time, 'api', 'events', 'auto_paid', $pay_id, $contact_id);

?>