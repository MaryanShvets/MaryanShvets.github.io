<?

	// http://polza.com/app/api/antitreningi/control/member.php?email=levchenkovic@gmail.com&integration_id=2755&secret=yncflsu&first_name=Виктор&status=active

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 1);

    // Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

    $time = $api->pulse_timer(false);

	// Получаем переменные 
	$email = $_GET['email'];
	$integration_id = $_GET['integration_id'];
	$first_name = $_GET['first_name'];
	$secret = $_GET['secret'];
	$status = $_GET['status'];

	$last_name = '';
	$phone = '';

	$hash = md5($email . ":" . $integration_id . ":" . $first_name . ":" . $last_name . ":" . $phone . ":" . $secret);

	// Формируем запрос
	$fields = array(
			'email'=>$email,
			'integration_id'=>$integration_id,
			'first_name'=>$first_name,
			'status'=>$status,
			'hash'=>$hash
		);

	// Отправляем запрос на обновление контактной информации
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_URL,'http://antitreningi.ru/api/benefits/crm');
    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
    curl_setopt($ch,CURLOPT_HEADER,false);
    $out=curl_exec($ch); 
    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

    echo $out;
    echo '<br>';
    echo $code;

   	$time = $api->pulse_timer($time);
	$api->pulse_log($time, 'api', 'antitreningi', 'member', $integration_id, $email);
?>