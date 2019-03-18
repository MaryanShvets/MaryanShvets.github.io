<?php 


include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/sms.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');

$time = Pulse::timer(false);

$pay_id = $_GET['id'];

if (empty($pay_id)) {
	die();
}

MySQL::connect();


$payment = MySQL::query(" SELECT * FROM `app_payments` WHERE `pay_id` = '$pay_id' LIMIT 1 ");

if ($payment['status'] == 'success') 
{
	die();
}

$date_mod = date( 'Y-m-d H:i:s');
MySQL::query(" UPDATE `app_payments` SET `status`='success', `date_mod`='$date_mod' WHERE `pay_id` = '$pay_id' ");

$pulse = array();

// Если это автоматическая оплата
if($payment['type']=='payment'){

	$pulse['object'] = 'payment';
	$pulse['id'] = $pay_id;

	$bot_text = 'Зафиксирована автоматическая оплата в Fondy по выставленному счету №'.$pay_id.'. Информация передана на событие.';
	// $bot->say_test($bot_text);

	$get_url = 'http://polza.com/app/core/events/paid_auto.php?id='.$pay_id;
	file_get_contents($get_url);
}

// Если это оплата инвойса
elseif($payment['type']=='invoice'){

	$pulse['object'] = 'invoice';
	$pulse['id'] = $pay_id;

	$get_url = 'http://polza.com/app/core/events/paid_invoice.php?id='.$payment['id'];
	file_get_contents($get_url);
}

$date_mod = date( 'Y-m-d H:i:s');
MySQL::query(" UPDATE `app_payments` SET `status`='success', `date_mod`='$date_mod' WHERE `pay_id` = '$pay_id' ");

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'pay2me_callback', 'success', $pulse['object'], $pulse['id']);


?>