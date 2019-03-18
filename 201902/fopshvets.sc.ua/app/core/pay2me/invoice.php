<?php

    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/access.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pay2me.php');

    $time = Pulse::timer(false);

    MySQL::connect();

    // Готовим данные
	$invoice_id = $_GET['id'];
	$invoice_info = MySQL::query(" SELECT * FROM `app_payments` WHERE `id` = '$invoice_id' LIMIT 1 ");

    $pre_order = time();

    $order = array(
        'order_id'=>$_GET['id'],
        'order_desc'=>$invoice_info['order_desc'],
        'order_amount'=>$invoice_info['pay_amount'],
        'order_return'=>'http://polza.com/app/core/pay2me/callback?id='.$pre_order
    );

    $pay = new Pay2MeApi;

    $result = $pay->dealCreate($order['order_id'], $order['order_desc'], $order['order_amount'], $order['order_return']);
    $array =  (array) $result;

    MySQL::query(" UPDATE `app_payments` SET `pay_id`='$pre_order' WHERE `id` = '$invoice_id' LIMIT 1");

    $time = Pulse::timer($time);
	Pulse::log($time, 'core', 'pay2me_invoice', 'ok', $pre_order, $invoice_id);

    // Редирект пользователя на страницу оплаты
    header('Location: '.$array['redirect'].'');
 
?>