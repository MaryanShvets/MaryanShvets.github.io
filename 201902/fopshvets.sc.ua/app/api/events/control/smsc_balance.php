<?


	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	$api = new API();

    $time = $api->pulse_timer(false);
	$url = 'https://smsc.ru/sys/balance.php?login=polzacom&psw=Molotok2017!!&fmt=3';

	$data = file_get_contents($url);
	$data = json_decode($data, true);
	$balance = $data['balance'];
	$balance = round($balance);

	$api->pulse_log('0', 'api', 'events', 'smsc_balance', '0', $balance);


?>