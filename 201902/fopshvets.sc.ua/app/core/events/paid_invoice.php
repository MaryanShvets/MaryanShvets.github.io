<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');

$time = Pulse::timer(false);

MySQL::connect();

$id = $_GET['id'];

$payment = MySQL::query(" SELECT * FROM `app_payments` WHERE `id` = '$id' LIMIT 1 ");

$bot_text = '💰 Оплачен счет '.$payment['pay_amount'].' '.$payment['pay_currency'].' '.$payment['email'].' '.$payment['order_desc'];
Slack::report($bot_text);

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_paid_invoice', '0', '0', $id);

?>