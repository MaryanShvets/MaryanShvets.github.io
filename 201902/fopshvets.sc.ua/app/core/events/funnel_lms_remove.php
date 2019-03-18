<?

ini_set('display_errors', 0);

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/antitreningi.php');

$time = Pulse::timer(false);

$key = $_GET['key'];
$secret = $_GET['secret'];
$email = $_GET['email'];
$phone = $_GET['phone'];

$antitreningi_status = Antitreningi::remove('', $email, $key, $secret);

if ($antitreningi_status !== 200) {
	Slack::ganeral('У меня не получилось удалить ученика с АнтиТренингов %0A'. $email.' / '.$key.' /'.$secret);
	Pulse::log('0', 'core', 'lib_antitreningi', 'error', $key, $secret);
}

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_funnel_lms_remove', $antitreningi_status, $email, '0');

?>