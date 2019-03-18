<?

	// Получаем данные
	$data = file_get_contents('php://input');
	$data = $_POST;

	// Если параметр с СМС не пустой
	if (!empty($_GET['sms'])) {

		// Отправляем СМС
		$sms = $_GET['sms'];
		$url = 'http://polza.com/app/api/events/control/send_sms.php?sms='.$sms.'&phone='.$data['contact']['phone'];
		file_get_contents($url);
	}

?>