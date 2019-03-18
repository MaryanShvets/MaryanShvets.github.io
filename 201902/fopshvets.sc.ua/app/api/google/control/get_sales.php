<?

	// http://polza.com/app/api/google/control/get_sales.php?product=367&utm_source=0

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 0);

	// Подключаем основной клас и Telegram бота
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

	$api = new API();

	$time = $api->pulse_timer(false);

    // Подключаем БД
	API::connect();

	$id = $_GET['product'];
	$utm_source = $_GET['utm_source'];

	$data = API::query( " 
		SELECT COUNT(*)  as `count` FROM `app_payments` WHERE `order_id` IN(
				SELECT `id` FROM `app_leads` WHERE `product` ='$id' AND `utmsourse` = '$utm_source'
			) AND `status` = 'success' 
	" );

	$data_array = array(
		'count'=>$data['count']
	);
	
	echo json_encode(array($data_array));

	$time = $api->pulse_timer($time);
    $api->pulse_log($time, 'api', 'google', 'get_sales', $utm_source, $id);

?>