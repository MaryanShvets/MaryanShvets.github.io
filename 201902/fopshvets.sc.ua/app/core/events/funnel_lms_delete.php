<?

ini_set('display_errors', 0);

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/todoist.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/antitreningi.php');

$time = Pulse::timer(false);

$key = $_GET['key'];
$secret = $_GET['secret'];
$email = $_GET['email'];
$phone = $_GET['phone'];

$antitreningi_status = Antitreningi::delete('', $email, $key, $secret);

echo $antitreningi_status;

if ($antitreningi_status !== 200) {

	// echo 'У меня не удалось удалить ученика с курса';
	// Slack::ganeral('У меня не получилось удалить ученика с АнтиТренингов %0A'. $email.' / '.$key.' /'.$secret);
	// Pulse::log('0', 'core', 'lib_antitreningi', 'error', $key, $secret);
	$bot_text = 'У меня не удалось удалить ученика '.$email.' с курса используя ключи '.$key.' '.$secret;
	// Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));
}
else
{
	$bot_text = 'Теперь я и правда удалил ученика '.$email.' с курса используя ключи '.$key.' '.$secret;
	// Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));
}

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_funnel_lms_delete', $antitreningi_status, $email, '0');

// http://polza.com/app/core/events/funnel_lms_delete?key=3752&secret=glsfbgc&phone=0&email=aleks.m.roschyn@gmail.com







// $email = $_GET['email'];
// echo Todoist::add('Удалить ученика '.$email.' с курса !!1 today', '5b5905c17b8cdb55951e8ddb452c451c147736b7', '$_kurs_delete');

// $time = Pulse::timer($time);
// Pulse::log($time, 'core', 'events_funnel_lms_delete', '0', $email, '0');

// http://polza.com/app/core/events/funnel_lms_delete?&email=test@polza.com
// http://polza.com/app/core/events/funnel_lms_delete?&email=%EMAIL%

?>