<?

	// Vd7lIzjTNi1wEBGH+sb5k0bh

	// kDodNGQCosgjdcFOa9lFR64h Жицкая

	// 4E053F065CF9461C2BA75BCCDE862855C3E7232311D0B91C1E0C87F0907F5FD0

	// Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

    // Подключаем БД
	$api->connect();

	// Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
    $bot = new Slack();

    $bot_text = 'yandex';

    $bot->say_test($bot_text);

    if(!empty($_POST['label'])){
    	$id = $_POST['label'];

    	$card_from = $_POST['sender'];

    
		$date_create_sql = date("Y-m-d H:i:s", strtotime('+7 hours'));
		$system = 'yandex-money';

		if (!empty($_POST['email'])) {
			$email = $_POST['email'];
		}else{
			$email = '0';
		}

		$amount = $_POST['amount'];
		$currency = 'RUB';
		$desc = 'Оплата Яндекс денег';

    	$api->query(" INSERT INTO `app_payments`( `status`, `order_id`, `date_create`, `pay_channel`, `type`, `email`, `pay_amount`, `pay_currency`, `order_desc` ) VALUES ('success','$id', '$date_create_sql', '$system', 'invoice', '$email', '$amount', '$currency', '$desc' ) ");

    }else{

    	$amo = '0';
		$date_create_sql = date("Y-m-d H:i:s", strtotime('+7 hours'));
		$system = 'yandex-money';

		if (!empty($_POST['email'])) {
			$email = $_POST['email'];
		}else{
			$email = '0';
		}

		$amount = $_POST['amount'];
		$currency = 'RUB';
		$desc = 'Ручной перевод на кошелек';

    	$api->query(" INSERT INTO `app_payments`( `status`, `order_id`, `date_create`, `pay_channel`, `type`, `email`, `pay_amount`, `pay_currency`, `order_desc` ) VALUES ('success','$amo', '$date_create_sql', '$system', 'invoice', '$email', '$amount', '$currency', '$desc' ) ");
    }

 	// operation_id = 904035776918098009
	// notification_type = p2p-incoming
	// datetime = 2014-04-28T16:31:28Z
	// sha1_hash = 8693ddf402fe5dcc4c4744d466cabada2628148c
	// sender = 41003188981230
	// codepro = false
	// currency = 643
	// amount = 0.99
	// withdraw_amount = 1.00
	// label = YM.label.12345
	// lastname = Иванов
	// firstname = Иван
	// fathersname = Иванович
	// zip = 125075
	// city = Москва
	// street = Тверская
	// building = 12
	// suite = 10
	// flat = 10
	// phone = +79253332211
	// email = adress@yandex.ru

?>