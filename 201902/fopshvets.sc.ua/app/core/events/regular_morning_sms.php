<?

// http://polza.com/app/core/events/regular_morning_sms

// Отображение ошибок (1 – показывать, 0 – скрывать)




	ini_set('display_errors', 1);

// Подключаем основной клас

	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	$api = new API();


	// $api->send_sms('morning cron 3', '', '380933843132');

	// die();

    // $time = $api->pulse_timer(false);

	$api->connect();

// Подключаем Telegram бота

	// include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
	// $bot = new Slack();

	$all_sum = 0;

	$data = mysql_query(" SELECT * FROM `app_payments_config` WHERE `system` = 'privat24' AND `status` = 'active' LIMIT 500 ") or die(mysql_error());
		
	while ($row = mysql_fetch_array($data)) {

			$requesst_id = $row['key2'];
			$requesst_pass = $row['key3'];
			$requesst_card = $row['key1'];

			$requesst_url = 'http://polza.com/app/api/privatbank/control/get_balace.php';
			$requesst_url.= '?id='.$requesst_id.'&pass='.$requesst_pass.'&card='.$requesst_card;

		$re = '/(.*?)\.(.*?) (.*?)\z/';
		$str = file_get_contents($requesst_url);

		preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);


		$sum = $matches[0][1];
		$currency = $matches[0][3];

		// echo $sum.' / '.$currency.'<br>';

		if ($currency == 'UAH') {
			$all_sum = $all_sum + $sum;
		}elseif($currency == 'USD'){

			$sum = $sum * 26.3;
			$all_sum = $all_sum + $sum;

		}elseif($currency == 'EUR'){

			$sum = $sum * 30.5;
			$all_sum = $all_sum+$sum;
		}

		// $api->pulse_log('0', 'api', 'events', 'morning_sms', 'privat24_'.$row['id'], $sum);

	}

	$data_fondy = mysql_query(" SELECT * FROM `app_payments_config` WHERE `system` = 'fondy' AND `status` = 'active' LIMIT 500 ") or die(mysql_error());

	while ($row = mysql_fetch_array($data_fondy)) {
		

		$merchant_id = $row['key1'];
		$merchant_pass = $row['key2'];

		$date_from = date("d.m.Y",mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$date_to = date("d.m.Y",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));   

		$sign_string = $merchant_pass.'|'.$date_from.'|'.$date_to.'|'.$merchant_id;
		$sign=sha1($sign_string);

		$request = '{
			  "request": {
			    "merchant_id": "'.$merchant_id.'",
			    "date_from": "'.$date_from.'",
			    "date_to": "'.$date_to.'",
			    "signature": "'.$sign.'"
			  }
			}';

		// Отправляем запрос
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://api.fondy.eu/api/reports/");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = json_decode(curl_exec ($ch), JSON_OBJECT_AS_ARRAY);
		curl_close ($ch);

		$output = $output['response'];

		$summ = 0;

		foreach ($output as $key => $value) {

			if ($value['settlement_amount'] == 0 && $value['response_status']=='success' ) {
				$amount = $value['actual_amount'];
				$fee = $value['fee_oplata'];

				$amount = round($amount / 100);
				$fee = round($fee / 100);
				$amount = $amount - $fee;

				$summ = $summ + $amount;
			}
			
		}

		// $api->pulse_log('0', 'api', 'events', 'morning_sms', 'fondy_'.$row['id'], $summ);

		$all_sum = $all_sum+$summ;
	}

	// if(is_int($all_sum))
	// {
	$text = number_format($all_sum);
	
	// $api->send_sms($text, '', '380933843132');
	$api->send_sms($text, '', '380631744417');
	// $api->send_sms($text, '', '380958280236');

	// }
	// else
	// {
		// $api->send_sms('something went wrong', '',  '380933843132');
	// }


	// $pulse_sum = $all_sum;
	// $text = number_format($all_sum);

	// $api->send_sms($text, '', '380933843132');
	// $api->send_sms($text, '', '380631744417');

	// $time = $api->pulse_timer($time);
	// $api->pulse_log($time, 'api', 'events', 'morning_sms', '0', $pulse_sum);

?>