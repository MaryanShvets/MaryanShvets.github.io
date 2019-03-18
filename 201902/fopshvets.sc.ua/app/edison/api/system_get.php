<?

	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

	$api = new API();
	$api->connect();

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

	}elseif($key1 == 'api'){

		switch ($key2) {

			case 'submits':

					$product = API::query(" SELECT `amoName`, `amoview`, `grview`, `URL`, `redirect`, `redirectPay`, `smsview`, `LMSview` FROM `products` WHERE `id` ='$key4' LIMIT 1");
					
					
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
					

					// echo '<strong>Платформа (вкл/выкл) </strong> ';
					// echo $product['LMSview'].'<br>';

					$contact = API::query(" SELECT * FROM `app_contact` WHERE `id` ='$key5' LIMIT 1");

					echo '<strong>Имя </strong> ';
					echo $contact['name'].'<br>';

					echo '<strong>Емейл </strong> ';
					echo $contact['email'].'<br>';

					echo '<strong>Телефон </strong> ';
					echo $contact['phone'].'<br>';

				break;

			case 'antitreningi':
					echo '<strong>Время </strong> ';
					echo $time.' с.<br>';
					// echo 'Информация пока не готова';
				break;

			case 'events':
					echo '<strong>Время </strong> ';
					echo $time.' с.<br>';
				break;

			case 'activecampaign':
					echo '<strong>Время </strong> ';
					echo $time.' с.<br>';
				break;

			case 'google':

					$product = API::query(" SELECT `amoName` FROM `products` WHERE `id` ='$key5' LIMIT 1");
					
					echo '<strong>Время </strong> ';
					echo $time.' с.<br>';
					echo '<strong>Продукт </strong> ';
					echo $product['amoName'].'<br>';
				break;
		}
	}

?>