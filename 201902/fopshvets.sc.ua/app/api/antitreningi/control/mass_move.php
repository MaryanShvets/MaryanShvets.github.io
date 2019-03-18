<?

// Отображение ошибок (1 – показывать, 0 – скрывать)
ini_set('display_errors', 1);

// Подключаем Telegram бота
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
$bot = new Slack();

$client = array('first_name'=>'','phone'=>'', 'email'=>'');


foreach ($variable as $key => $value) {

	// Получаем переменные 
	$email = $_GET['email'];
	$integration_id = $_GET['integration_id'];
	$first_name = $_GET['first_name'];
	$secret = $_GET['secret'];
	$status = $_GET['status'];
	$hash = md5($email.':'. $integration_id .':'. $first_name .':'. $secret);

	// Формируем запрос
	$fields = array(
			'email'=>$email,
			'integration_id'=>$integration_id,
			'first_name'=>$first_name,
			'phone'=>$phone,
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

	$bot_text = 'участник Антитренингов '.$status.' '.$integration_id.' '.$email.' '.$phone;
	$bot->say_test($bot_text);

}




?>