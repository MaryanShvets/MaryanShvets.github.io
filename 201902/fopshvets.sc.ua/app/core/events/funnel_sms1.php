<?

$file = 'activecampain-sms1.log';
$current = "\r\n".date("Y-m-d H:i:s")." ------------------------------------------------------ request http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']} \r\n".print_r($_REQUEST, true);
$current .= "\r\n".date("Y-m-d H:i:s")."get \r\n".print_r($_GET, true);
$current .= "\r\n".date("Y-m-d H:i:s")."post \r\n".print_r($_POST, true);
file_put_contents($file, $current, FILE_APPEND);
echo 'ok';
die();
ini_set('display_errors', 0);

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/sms.php');

$time = Pulse::timer(false);

// Подключаем БД
MySQL::connect();

// Присваеваем переменные
$sms = $_GET['sms'];
//$phone = $_GET['contact']['phone'];
$phone = $_GET['phone'];

// Получаем текст смс с БД
$text = MySQL::query( "SELECT * FROM `app_funnel_items` WHERE `id` = '$sms' LIMIT 1 ");
$text = $text['text'];

// Отправляем смс
SMS::send($text, '', $phone);

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_funnel_sms', '0', $sms, $phone);


?>