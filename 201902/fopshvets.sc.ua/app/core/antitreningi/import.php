<?

ini_set('display_errors', 1);

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
// include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/ivr.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/sms.php');

// $key = '3030';
// $secret = 'ioncjgz';

$phones = array(
'380504135715',
'380962459287',
'77774642659'
);


// $sms = $_GET['sms'];
// $phone = '380933843132';

// Получаем текст смс с БД
// $file_audio = MySQL::query( "SELECT * FROM `app_funnel_items` WHERE `id` = '$sms' LIMIT 1 ");
// $file_audio = 'https://smsc.ru/upload/files/sms/62c806d8/stendap-privet_sovsem_skoro_0.35.mp3';

// Отправляем смс

foreach ($phones as $value) {

	// IVR::send($file_audio, $value);

	// SMS::send('Деньги - следствие. Причина - ты.', '', $value);

	// Antitreningi::add('', $value, $key, $secret);
	echo 'done '.$value.'<br>';
}

?>