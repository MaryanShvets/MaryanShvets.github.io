<?

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 0);

    // Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

    $time = $api->pulse_timer(false);

    $sms = $_GET['sms'];
    $phone = $_GET['phone'];

    // Тексты смс пока будем сохранять здесь
	$text = array(
			'call-ivr-1'=>'https://smsc.ru/upload/files/sms/62c806d8/privet_0.30.wav'
		);

	$form_phone = preg_replace('~\D+~','',$phone); 
	$file = $text[$sms];
	$file = urlencode($file);
	$sms_url = 'https://smsc.ru/sys/send.php?login=polzacom&psw=Molotok2017!!&phones='.$form_phone.'&mes='.$file.'&call=1';
	file_get_contents($sms_url);

	$time = $api->pulse_timer($time);
	$api->pulse_log($time, 'api', 'events', 'send_ivr', $sms, $phone);
?>