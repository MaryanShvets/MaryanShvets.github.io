<?php

    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/access.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pay2me.php');

    $time = Pulse::timer(false);

    MySQL::connect();

    $fin_data = Access::finance('random','pay2me');

    if ($fin_data['status'] !== 'active') 
    {
        $time = Pulse::timer($time);
        Pulse::log($time, 'core', 'pay2me_pay', 'redirect', 'pause', 'fondy');

        $url = 'http://polza.com/app/core/fondy/pay.php?price='.$_GET['price'].'&order='.$_GET['order'].'&currency='.$_GET['currency'].'&order_desc='.$_GET['order_desc'].'&sign='.$_GET['sign'].'';
        header('Location: '.$url.'');

        die();
    }


    $sign_check = $_GET['price'].'|'.$_GET['order'].'|'.$_GET['currency'].'|'.$_GET['order_desc'].'|fuckyou';
    $sign_check = md5($sign_check);

    if ($sign_check !== $_GET['sign']) { 

        function get_client_ip() {
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
               $ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }

        include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
        $bot = new Slack();

        $ip = get_client_ip();

        $bot_text = '🚨 Какой-то мелкий ублюдок хотел взламать оплату через Pay2Me ('.$ip.')';
        Slack::general($bot_text);
        Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));

        echo 'Произошла ошибка системы безопасности.';

        $time = Pulse::timer($time);
        Pulse::log($time, 'core', 'pay2me_pay', 'warning', 'security', $ip);

        echo 'Произошла ошибка системы безопасности.';
        die();
    }


    $pre_order = time();

    $order = array(
        'order_id'=>$_GET['order'],
        'order_desc'=>$_GET['order_desc'],
        'order_amount'=>$_GET['price'],
        'order_return'=>'http://polza.com/app/core/pay2me/callback?id='.$pre_order
    );

    $pay = new Pay2MeApi;

    $result = $pay->dealCreate($order['order_id'], $order['order_desc'], $order['order_amount'], $order['order_return']);

    $array =  (array) $result;

    $id = $_GET['order'];
    $lead = MySQL::query(" SELECT `contact`,`product` FROM `app_leads` WHERE `id` = '$id' LIMIT 1 ");
    $contact_id = $lead['contact'];
    $contact = MySQL::query(" SELECT * FROM `app_contact` WHERE `id` = '$contact_id' LIMIT 1 ");
    $name = $contact['name'];
    $email = $contact['email'];
    $phone = $contact['phone'];
    $product_id = $lead['product'];
    $product = MySQL::query(" SELECT * FROM `products` WHERE `id` = '$product_id' LIMIT 1 ");
    $comment_text = 'Платеж по продукту '.$product['amoName'].' от клиента '.$name.' '.$phone.' '.$email;
    $pay_channel = 'pay2me';
    $pay_id = $pre_order;
    $pay_system = '0';
    $pay_amount = $_GET['price'];
    $pay_currency = $_GET['currency'];
    $status = 'new';
    $card_from = '0';
    $card_type = '0';
    $card_to = 'pay2me';
    $comment = '0';
    $order_id = $_GET['order'];
    $order_desc = $comment_text;

    // Записываем данные
    $date_create_sql = date("Y-m-d H:i:s", strtotime('+6 hours'));
    MySQL::query(" INSERT INTO `app_payments`( `date_create`, `pay_channel`, `pay_id`, `pay_system`, `pay_amount`, `pay_currency`, `status`, `card_from`, `card_type`, `card_to`, `comment`, `order_id`, `order_desc`) VALUES ('$date_create_sql', '$pay_channel', '$pay_id', '$pay_system', '$pay_amount', '$pay_currency', '$status', '$card_from', '$card_type', '$card_to', '$comment', '$order_id', '$order_desc' ) ");


    $time = Pulse::timer($time);
    Pulse::log($time, 'core', 'pay2me_pay', 'ok', $id, $contact_id);

    // Редирект пользователя на страницу оплаты
    header('Location: '.$array['redirect'].'');
 
?>