<?

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 0);

	// Подключаем основной клас
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

    // Подключаем Telegram бота
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
    $bot = new Slack();

    // Подключаем config файл с настройками статусов
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/config/status.php');

    // Подключаем БД
	$api->connect();

	// Разбираем полученые с AmoCRM данные
	$data = $_POST['leads']['status'];
	foreach ($data as $key => $value) {

		// Присваеваем переменным их значения
		$lead_id = $value['id'];
		$product = $value['name'];
		$price = $value['price'];
		$price_bot = $value['price'];
		$status = $value['status_id'];
		$responsible_user_id = $value['responsible_user_id'];

		// Получаем человеко-понятное название статуса
		foreach ($status_list as $key => $value) {
			if ($status == $value['status_id']) {
				$bot_status = $value['status_name'];
			}
		}

		// Обновляем изменения в сделке
		$date_mod = date( 'Y-m-d H:i:s');
		$api->query(" UPDATE `app_leads` SET `status`='$status', `manager`='$responsible_user_id',`dateofchange`='$date_mod' WHERE `amo` = '$lead_id' ");

		$bot_text = $product.' / '.$bot_status;
		// $bot->say_test($bot_text);

		// Если это оплата
		if ($status == 142) {

			$bot_text = '💰 Оплата '.$price_bot.'$  *'.$product.'*';
			// $bot->say($bot_text);

			// Отправляем событие про оплату в AmoCRM
			$get_url = 'http://polza.com/app/api/events/control/crm_paid.php?id='.$lead_id;
			file_get_contents($get_url);

		// Если это предоплата
		}elseif($status == 10511995){

			    $custom_fields = $value['custom_fields'];
			    foreach ($custom_fields as $key => $item) {
			    		if ($item['id'] == 1276624) {
			    			$custom_field = $custom_fields[$key]['values'];
			        		$prepeyment = $custom_field[$key]['value'];
			    		} 
			    }

			$bot_text = '💰 Предоплата '.$prepeyment.'$ *'.$product.'* ('.$price_bot.'$)';
			// $bot->say($bot_text);

			// Отправляем событие про оплату в AmoCRM
			$get_url = 'http://polza.com/app/api/events/control/crm_paid.php?id='.$lead_id;
			file_get_contents($get_url);
		}
		
	}
?>