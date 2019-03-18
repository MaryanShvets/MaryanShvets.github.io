<?

ini_set('display_errors', 0);
 $file = 'activecampain_lms.log';
 $current = "\r\n1 ".date("Y-m-d H:i:s")."\r\n".print_r($_REQUEST, true);
 file_put_contents($file, $current, FILE_APPEND); //echo "dddddd";

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/antitreningi.php');

$time = Pulse::timer(false);

$key = $_GET['key'];
$secret = $_GET['secret'];
$email = $_GET['email'];


if (!empty($_GET['name']) && $_GET['name'] !== '0') {

	$antitreningi_status = Antitreningi::add($_GET['name'], $email, $key, $secret);

}elseif(!empty($_GET['name']) && $_GET['name'] == '0'){

	$antitreningi_status = Antitreningi::add('', $email, $key, $secret);

}else{

	$antitreningi_status = Antitreningi::add('', $email, $key, $secret);
}


if ($antitreningi_status !== 200) {

	Slack::general('У меня не получилось добавить ученика в АнтиТренинг %0A'. $email.' / '.$key.' /'.$secret);
	Pulse::log('0', 'core', 'lib_antitreningi', 'error', $key, $secret);
}

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_funnel_lms', $antitreningi_status, $email, '0');

// http://polza.com/app/core/events/funnel_lms?key=3430&secret=slheglq&phone=0&email=vl@polza.com&name=Viktor
// http://polza.com/app/core/events/funnel_lms?key=3430&secret=slheglq&phone=0&email=vl1@polza.com
// http://polza.com/app/core/events/funnel_lms?key=3430&secret=slheglq&phone=0&email=vl4@polza.com&name=Дедлайн
?>