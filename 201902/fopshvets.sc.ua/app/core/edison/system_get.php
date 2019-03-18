<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');
MySQL::connect();

$time = $_GET['time'];
$time = round($time, 2);
$key1 = $_GET['key1'];
$key2 = $_GET['key2'];
$key3 = $_GET['key3'];
$key4 = $_GET['key4'];
$key5 = $_GET['key5'];

if ($key1 == 'edison') {

	switch ($key2) {
		case 'user_signin':
				echo '<strong>Время </strong> ';
				echo $time.' с.<br>';
			break;
	}
}

elseif($key1 == 'api'){

	echo '<strong>Время </strong> ';
	echo $time.' с.<br>';
	echo 'Старый формат отчета.';

	// switch ($key2) {

	// 	case 'submits':

	// 			$product = API::query(" SELECT `amoName`, `amoview`, `grview`, `URL`, `redirect`, `redirectPay`, `smsview`, `LMSview` FROM `products` WHERE `id` ='$key4' LIMIT 1");
				
				
	// 			if ($product['amoview']=='1') {
	// 			echo '<img src="/app/control/frontend/svg/basic_headset-active.svg"/>';
	// 			}else{
	// 				echo '<img src="/app/control/frontend/svg/basic_headset.svg"/>';
	// 			}
	// 			if ($product['grview']=='1') {
	// 				echo '<img src="/app/control/frontend/svg/basic_mail_multiple-active.svg"/>';
	// 			}else{
	// 				echo '<img src="/app/control/frontend/svg/basic_mail_multiple.svg"/>';
	// 			}
	// 			if ($product['smsview']=='1') {
	// 				echo '<img src="/app/control/frontend/svg/basic_smartphone-active.svg"/>';
	// 			}else{
	// 				echo '<img src="/app/control/frontend/svg/basic_smartphone.svg"/>';
	// 			}
	// 			if ($product['LMSview']=='1') {
	// 				echo '<img src="/app/control/frontend/svg/basic_book_pencil-active.svg"/>';
	// 			}else{
	// 				echo '<img src="/app/control/frontend/svg/basic_book_pencil.svg"/>';
	// 			}

	// 			echo '<br>';

	// 			echo '<strong>Время </strong> ';

	// 			if ($time > 2.5) {
	// 				echo $time.' секунд / <span style="color:red;">медленно</span>';
	// 			}else{
	// 				echo $time.' секунд / <span style="color:green;">быстро</span>';
	// 			}

	// 			echo '<br>';

	// 			echo '<strong>Продукт </strong> ';
	// 			echo $product['amoName'].'<br>';

	// 			echo '<strong>Страница </strong> ';
	// 			echo $product['URL'].'<br>';

	// 			echo '<strong>Переадресация </strong> ';
	// 			echo $product['redirect'].'<br>';

	// 			echo '<strong>Успешная оплата </strong> ';
	// 			echo $product['redirectPay'].'<br>';
				

	// 			// echo '<strong>Платформа (вкл/выкл) </strong> ';
	// 			// echo $product['LMSview'].'<br>';

	// 			$contact = API::query(" SELECT * FROM `app_contact` WHERE `id` ='$key5' LIMIT 1");

	// 			echo '<strong>Имя </strong> ';
	// 			echo $contact['name'].'<br>';

	// 			echo '<strong>Емейл </strong> ';
	// 			echo $contact['email'].'<br>';

	// 			echo '<strong>Телефон </strong> ';
	// 			echo $contact['phone'].'<br>';

	// 		break;

	// 	case 'antitreningi':
	// 			echo '<strong>Время </strong> ';
	// 			echo $time.' с.<br>';
	// 			// echo 'Информация пока не готова';
	// 		break;

	// 	case 'events':
	// 			echo '<strong>Время </strong> ';
	// 			echo $time.' с.<br>';
	// 		break;

	// 	case 'activecampaign':
	// 			echo '<strong>Время </strong> ';
	// 			echo $time.' с.<br>';
	// 		break;

	// 	case 'google':

	// 			$product = API::query(" SELECT `amoName` FROM `products` WHERE `id` ='$key5' LIMIT 1");
				
	// 			echo '<strong>Время </strong> ';
	// 			echo $time.' с.<br>';
	// 			echo '<strong>Продукт </strong> ';
	// 			echo $product['amoName'].'<br>';
	// 		break;
	// }

}elseif($key1 == 'core'){

	switch ($key2) {

		case 'submit_new':

				$product = MySQL::query(" SELECT `amoName`, `amoview`, `grview`, `URL`, `redirect`, `redirectPay`, `smsview`, `LMSview` FROM `products` WHERE `id` ='$key4' LIMIT 1");
				
				
				if ($product['amoview']=='1') {
				echo '<img src="/app/control/frontend/svg/basic_headset-active.svg"/>';
				}else{
					echo '<img src="/app/control/frontend/svg/basic_headset.svg"/>';
				}
				if ($product['grview']=='1') {
					echo '<img src="/app/control/frontend/svg/basic_mail_multiple-active.svg"/>';
				}else{
					echo '<img src="/app/control/frontend/svg/basic_mail_multiple.svg"/>';
				}
				if ($product['smsview']=='1') {
					echo '<img src="/app/control/frontend/svg/basic_smartphone-active.svg"/>';
				}else{
					echo '<img src="/app/control/frontend/svg/basic_smartphone.svg"/>';
				}
				if ($product['LMSview']=='1') {
					echo '<img src="/app/control/frontend/svg/basic_book_pencil-active.svg"/>';
				}else{
					echo '<img src="/app/control/frontend/svg/basic_book_pencil.svg"/>';
				}

				echo '<br>';

				echo '<strong>Время </strong> ';

				if ($time > 2.5) {
					echo $time.' секунд / <span style="color:red;">медленно</span>';
				}else{
					echo $time.' секунд / <span style="color:green;">быстро</span>';
				}

				echo '<br>';

				echo '<strong>Продукт </strong> ';
				echo $product['amoName'].'<br>';

				echo '<strong>Страница </strong> ';
				echo $product['URL'].'<br>';

				echo '<strong>Переадресация </strong> ';
				echo $product['redirect'].'<br>';

				echo '<strong>Успешная оплата </strong> ';
				echo $product['redirectPay'].'<br>';
				
				$contact = MySQL::query(" SELECT * FROM `app_contact` WHERE `id` ='$key5' LIMIT 1");

				echo '<strong>Имя </strong> ';
				echo $contact['name'].'<br>';

				echo '<strong>Емейл </strong> ';
				echo $contact['email'].'<br>';

				echo '<strong>Телефон </strong> ';
				echo $contact['phone'].'<br>';

			break;

		case 'lib_ivr':
			
			echo '<strong>Время </strong> ';
			echo $time.' с.<br>';

			echo '<strong>Телефон </strong> ';
			echo $key5.'<br>';

			break;

		case 'lib_sms':
			
			echo '<strong>Время </strong> ';
			echo $time.' с.<br>';

			echo '<strong>Телефон </strong> ';
			echo $key5.'<br>';

			break;

		case 'events_funnel_ivr':
				
			echo '<strong>Время </strong> ';
			echo $time.' с.<br>';

			echo '<strong>Телефон </strong> ';
			echo $key5.'<br>';

			$text = MySQL::query(" SELECT * FROM `app_funnel_items` WHERE `id` ='$key4' LIMIT 1");

			echo '<strong>Сообщение </strong> ';
			echo $text['text'].'<br>';

			break;

		case 'events_funnel_sms':
				
			echo '<strong>Время </strong> ';
			echo $time.' с.<br>';

			echo '<strong>Телефон </strong> ';
			echo $key5.'<br>';

			$text = MySQL::query(" SELECT * FROM `app_funnel_items` WHERE `id` ='$key4' LIMIT 1");

			echo '<strong>Сообщение </strong> ';
			echo $text['text'].'<br>';

			break;

		case 'fondy_pay':

			echo '<strong>Время </strong> ';
			echo $time.' с.<br>';

			$payment = MySQL::query(" SELECT * FROM `app_payments` WHERE `pay_id` ='$key4' LIMIT 1");

			echo '<strong>Цена </strong> ';
			echo $payment['pay_amount'].' '.$payment['pay_currency'].'<br>';

			echo '<strong>Описание </strong> ';
			echo $payment['order_desc'].'<br>';

			break;

		case 'events_lms_rate':

			echo '<strong>Время </strong> ';
			echo $time.' с.<br>';

			// $lesson = MySQL::query(" SELECT * FROM `app_payments` WHERE `pay_id` ='$key4' LIMIT 1");

			// echo '<strong>Цена </strong> ';
			// echo $payment['pay_amount'].' '.$payment['pay_currency'].'<br>';

			// echo '<strong>Описание </strong> ';
			// echo $payment['order_desc'].'<br>';

			break;

		default:

			echo '<strong>Время </strong> ';
			echo $time.' с.<br>';

			break;

	}
}

?>