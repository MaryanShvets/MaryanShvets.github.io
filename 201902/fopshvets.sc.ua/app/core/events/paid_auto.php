<?

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/email.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/curl.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/antitreningi.php');

$time = Pulse::timer(false);

// Подключаем БД
MySQL::connect();

// Получаем ID оплаты
$pay_id = $_GET['id'];

// Проверяем информацию платежа
$payment = MySQL::query(" SELECT * FROM `app_payments` WHERE `pay_id` = '$pay_id' LIMIT 1 ");

// Если это автоматическая оплата
if($payment['type']=='payment'){

	// Получаем информацию про заявку, контакт и продукт
	$lead_id = $payment['order_id'];
	$lead = MySQL::query(" SELECT * FROM `app_leads` WHERE `id` = '$lead_id' LIMIT 1 ");

	$affilate_id = $lead['affilate'];

	$contact_id = $lead['contact'];
	$contact = MySQL::query(" SELECT * FROM `app_contact` WHERE `id` = '$contact_id' LIMIT 1 ");

	$product_id = $lead['product'];
	$product = MySQL::query(" SELECT * FROM `products` WHERE `id` = '$product_id' LIMIT 1 ");

	if ( $affilate_id !== '0' && $product['affilate_cost'] !=='0' ) 
	{
		$product_name = $product['amoName'];
		$affilate_cost = $product['affilate_cost'];
		MySQL::query(" INSERT INTO `app_affilate_payments`( `type`, `product`, `product_name`, `sub_id`, `amount`, `currency`, `affilate`) VALUES ('pay', '$product_id', '$product_name', '$lead_id', '$affilate_cost', 'USD', '$affilate_id') ");
	}
	
    $bot_text = '💰 Автооплата '.$product['amoName'].' / '.$payment['pay_amount'].' '.$payment['pay_currency'].' / '.$contact['email'];

    Slack::report($bot_text);

	// Если мы знаем куда переводить в емейлах
	if ($product['grEnd'] !== '0') {

		Email::update($contact['email'], $contact['name'], $contact['phone'], $product['grEnd'] );
	}

	// Если мы знаем куда переводить в АнтиТренинг
	if ($product['LMSview'] == '1') {

	    $antitreningi_status = Antitreningi::add($contact['name'], $contact['email'], $product['LMScode'], $product['LMSkey']);

	    if ($antitreningi_status !== 200) {
	    	Slack::personal('oleksandr.roshchyn', 'У мене не вийшло додати учня в АнтиТренінги '.$contact['name'].' / '. $contact['email'].' / '.$product['LMScode'].' /'.$product['LMSkey']);
	    	Pulse::log('0', 'core', 'lib_antitreningi', 'error', $product['LMScode'], $product['LMSkey']);
	    }
	}
}

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_paid_auto', '0', $pay_id, $contact_id);

?>