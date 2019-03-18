<?

ini_set('display_errors', 0);

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

// Подключаем БД
MySQL::connect();

$data = $_POST;

$email = $data['contact']['email'];
$campaign = $data['campaign']['id'];

// Записываем лог
$time = Pulse::timer($time);
//Pulse::log($time, 'core', 'activecampaign_webhook', '0', 'opened_'.$campaign, $email);
Pulse::log($time, 'core', 'activecampaign_webhook', '0', 'opened_'.$campaign, 'inneti.ad5@gmail.com');


$file = 'activecampain.log';
$current = "\r\n".date("Y-m-d H:i:s")."\r\n".print_r($_REQUEST, true);
file_put_contents($file, $current, FILE_APPEND);
?>