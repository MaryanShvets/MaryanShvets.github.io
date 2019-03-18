<?

	// Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

    // Подключаем БД
	$api->connect();

    // Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
    $bot = new Slack();

    // Получаем ID заявки в AmoCRM
	$id = $_GET['id'];

	// Получаем инфомрацию про заявку
	$lead = $api->query(" SELECT * FROM `app_leads` WHERE `amo` = '$id' LIMIT 1 ");
	$lead_id = $lead['id'];

	// Если нашли заявку и эта заявка не в Оплаченных полносью
	if(!empty($lead['id']) || $lead['status']!=='142' ){

		// Получаем информацию про заявку, контакт и продукт
		$contact_id = $lead['contact'];
		$contact = $api->query(" SELECT * FROM `app_contact` WHERE `id` = '$contact_id' LIMIT 1 ");

		$product_id = $lead['product'];
		$product = $api->query(" SELECT * FROM `products` WHERE `id` = '$product_id' LIMIT 1 ");

		// Если мы знаем куда переводить в емейлах
		if ($product['grEnd'] !== '0') {
			$api->add_email($contact['email'], $contact['name'], $contact['phone'], $product['grEnd'] );

			$bot_text = 'после оплаты в CRM, добавили почту '.$contact['email'].' в список '.$product['grEnd'].' ActiveCampaign';
    		// $bot->say_test($bot_text);
		}

		
		// Если мы знаем куда переводить в АнтиТренинг
		if ($product['LMSview'] == '1') {

			$bot_text = 'отправляю задачу в АнтиТренги ('.$product['LMScode'].', '.$product['LMSkey'].') '.$contact['email'].'';
		    $bot->say_test($bot_text);

			$site = 'http://polza.com/app/api/antitreningi/control/member.php';
			$site.= '?email='.$contact['email'].'&integration_id='.$product['LMScode'].'&secret='.$product['LMSkey'].'&first_name='.$contact['name'].'&status=active';

			$site = urlencode($site);
			
			file_get_contents($site);

		}
	}
?>