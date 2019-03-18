<?

ini_set('display_errors', 0);

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/ivr.php');

$time = Pulse::timer(false);

// Подключаем БД
MySQL::connect();

// Присваеваем переменные
$sms = $_GET['sms'];
$phone = $_GET['phone'];

// Получаем текст смс с БД
$file_audio = MySQL::query( "SELECT * FROM `app_funnel_items` WHERE `id` = '$sms' LIMIT 1 ");
$file_audio = $file_audio['text'];

// Отправляем смс
IVR::send($file_audio, $phone);

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_funnel_ivr', '0', $sms, $phone);

?>