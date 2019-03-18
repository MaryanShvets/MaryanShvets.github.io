<?


// Отображение ошибок (1 – показывать, 0 – скрывать)
ini_set('display_errors', 0);

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/access.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/curl.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');

$time = Pulse::timer(false);

	$sign_check = $_GET['price'].'|'.$_GET['order'].'|'.$_GET['currency'].'|'.$_GET['order_desc'].'|fuckyou';
	$sign_check = md5($sign_check);

	if ($sign_check !== $_GET['sign']) {

		function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	$ip = get_client_ip();

	$bot_text = '🚨 Какой-то мелкий ублюдок хотел взламать оплату через Fondy ('.$ip.')';
	Slack::general($bot_text);

	Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));

	echo 'Произошла ошибка системы безопасности.';

	$time = Pulse::timer($time);
	Pulse::log($time, 'core', 'fondy_pay', 'warning', 'security', $ip);

		die();
	}

// Этот файл формирует платеж для оплаты Фонди
// Мы создаем платеж и редиректим пользователя на страницу оплаты
// Документация Фонди должна быть здесь – https://portal.fondy.eu/ru/info/api/v1.0/3#chapter-3-5


// Подключаем БД
MySQL::connect();

$fin_data = Access::finance('random','fondy');

// Готовим данные
$merchant_id = $fin_data['key1'];
$merchant_pass = $fin_data['key2'];
$amount = $_GET['price'].'00'; 
$currency = $_GET['currency'];
$order_id = $_GET['order'].'-'.time();
$order_desc = $_GET['order_desc'];
$callback = 'http://polza.com/app/core/fondy/callback.php';

$id = $_GET['order'];
$lead = MySQL::query(" SELECT `contact`,`product` FROM `app_leads` WHERE `id` = '$id' LIMIT 1 ");
$product_id = $lead['product'];
$product = MySQL::query(" SELECT * FROM `products` WHERE `id` = '$product_id' LIMIT 1 ");

$pre_reponse_url = $product['redirectPay'];

// Готовим запрос
if ($pre_reponse_url == '0') {

	$sign_string = $merchant_pass.'|'.$amount.'|'.$currency.'|'.$merchant_id.'|'.$order_desc.'|'.$order_id.'|'.$callback;
	$sign=sha1($sign_string);

	$request = '{
	  "request": {
	    "amount": "'.$amount.'",
	    "currency": "'.$currency.'",
	    "merchant_id": "'.$merchant_id.'", 
	    "order_desc": "'.$order_desc.'",
	    "order_id": "'.$order_id.'",
	    "server_callback_url": "'.$callback.'",
	    "signature": "'.$sign.'"
	  }
	}';
}else{

	$sign_string = $merchant_pass.'|'.$amount.'|'.$currency.'|'.$merchant_id.'|'.$order_desc.'|'.$order_id.'|'.$pre_reponse_url.'|'.$callback;
	$sign=sha1($sign_string);

	$request = '{
	  "request": {
	    "amount": "'.$amount.'",
	    "currency": "'.$currency.'",
	    "merchant_id": "'.$merchant_id.'", 
	    "order_desc": "'.$order_desc.'",
	    "order_id": "'.$order_id.'",
	    "response_url": "'.$pre_reponse_url.'",
	    "server_callback_url": "'.$callback.'",
	    "signature": "'.$sign.'"
	  }
	}';
}

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
	$contact_id = $lead['contact'];
	$contact = MySQL::query(" SELECT * FROM `app_contact` WHERE `id` = '$contact_id' LIMIT 1 ");
	
	$name = $contact['name'];
	$email = $contact['email'];
	$phone = $contact['phone'];
	$comment_text = 'Платеж по продукту '.$product['amoName'].' от клиента '.$name.' '.$phone.' '.$email;
	$pay_channel = 'fondy';
	$pay_id = $output->response->payment_id;
	$pay_system = '0';
	$pay_amount = $amount / 100;
	$pay_currency = $currency;
	$status = 'new';
	$card_from = '0';
	$card_type = '0';
	$card_to = $merchant_id;
	$comment = '0';
	$order_id = $_GET['order'];
	$order_desc = $comment_text;

	// Записываем данные
	$date_create_sql = date("Y-m-d H:i:s", strtotime('+7 hours'));
	MySQL::query(" INSERT INTO `app_payments`( `date_create`, `pay_channel`, `pay_id`, `pay_system`, `pay_amount`, `pay_currency`, `status`, `card_from`, `card_type`, `card_to`, `comment`, `order_id`, `order_desc`) VALUES ('$date_create_sql', '$pay_channel', '$pay_id', '$pay_system', '$pay_amount', '$pay_currency', '$status', '$card_from', '$card_type', '$card_to', '$comment', '$order_id', '$order_desc' ) ");

	$time = Pulse::timer($time);
	Pulse::log($time, 'core', 'fondy_pay', 'ok', $pay_id, $contact_id);

	// Обнуляем переменные
	unset($pay_id, $order_id, $order_desc);

	// Редиректим пользователя на оплату
	header('Location: '.$output->response->checkout_url.'');
}
else{

	$bot_text = '🚨 Была попытка оплатить '.$order_desc.' по счету №'.$_GET['order'].', но у Fondy что-то сламалось: '.$output->response->error_message;
	Slack::general($bot_text);
	// Slack::personal('levchenkovic',$bot_text);
	// SMS::send('У Фонди что-то сламалось. Витя, спасай', '', '0933843132');

	Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));

	$time = Pulse::timer($time);
	Pulse::log($time, 'core', 'fondy_pay', 'warning', 'error', '0');

	echo 'Что-то пошло не так. Мы уже получили уведомление об ошибке и решаем ее.';
}

?>