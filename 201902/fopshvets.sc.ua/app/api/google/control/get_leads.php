<?

	// http://polza.com/app/api/google/control/get_leads.php?product=289

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 0);

	// Подключаем основной клас и Telegram бота
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	
	$api = new API();

	$time = $api->pulse_timer(false);

    // Подключаем БД
	$api->connect();

	$id = $_GET['product'];

	$data = mysql_query(" SELECT * FROM `app_leads` WHERE `product` = '$id' ORDER BY `app_leads`.`id`  DESC ") or die(mysql_error());
	
	$n = 0;
	while ($row = mysql_fetch_array($data)) {
		$data_array[$n]['product'] = $row['product'];
		$data_array[$n]['data'] = $row['data'];
		$data_array[$n]['utmsourse'] = $row['utmsourse'];
		$data_array[$n]['utmmedium'] = $row['utmmedium'];
		$data_array[$n]['utmcampaing'] = $row['utmcampaing'];
		$data_array[$n]['utmterm'] = $row['utmterm'];
		$n++;
	}

	echo json_encode($data_array);

	$time = $api->pulse_timer($time);
    $api->pulse_log($time, 'api', 'google', 'get_leads', '0', $id);

?>