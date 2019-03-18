<?

	$file = "config.json";
	$file_backup = "config-".$date_create_sql = date("Y-m-d_H-i-s", strtotime('+7 hours')).'.json';

	// rename($file, $file_backup);

	$json = json_decode(file_get_contents($file));

	$json = array(
		'fondy_merchant' => '1399238', 
		'fondy_pass' => '7zwgt2L2srYH2Vy0ao39SxQ1D4Sqj4Bw',
		'p24_card' => '5169330508353031',
		'p24_id' => '120242',
		'p24_pass' => 'd163CE6Vr9zQ09v7gzn1G9Mi698n95Yd',
		'wallet_merchant' => '196073408777',
		'wallet_key' => '7c34356b763845705b7b386a5b726533505e6e4c78516644694d74',
		'yandex_card' => '410012945267708'
	);

	// file_put_contents($file, json_encode($json));

?>