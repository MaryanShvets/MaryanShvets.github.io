<?php

    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/access.php');
    // include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/curl.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');

    $time = Pulse::timer(false);

    MySQL::connect();

    // Этот файл формирует платеж для оплаты Walletone
    // Мы создаем платеж и редиректим пользователя на страницу оплаты

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

        $bot_text = '🚨 Какой-то мелкий ублюдок хотел взламать оплату через Walletone ('.$ip.')';
        Slack::general($bot_text);
        Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));

        echo 'Произошла ошибка системы безопасности.';

        $time = Pulse::timer($time);
        Pulse::log($time, 'core', 'walletone_pay', 'warning', 'security', $ip);

        echo 'Произошла ошибка системы безопасности.';
        die();
    }


    // Подключаем БД
    MySQL::connect();

    $fin_data = Access::finance( 'random', 'walletone' );

    // Информация с кабинета Walletone
    $merchant = $fin_data['key1'];
    $key = $fin_data['key2'];
 
    // Готовим данные
    $fields = array(); 
    $order = $_GET['order'].'-'.time();

    // Форматируем валюту оплаты в международный код
    if($_GET['currency']=='UAH'){ $currency ='980'; }
    if($_GET['currency']=='RUB'){ $currency ='643'; }
    if($_GET['currency']=='USD'){ $currency ='840'; }
    if($_GET['currency']=='EUR'){ $currency ='978'; }

    $date_exp = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+30, date("Y"))).'T23:59:59';
    $fields["WMI_MERCHANT_ID"]    = $merchant;
    $fields["WMI_PAYMENT_AMOUNT"] = $_GET['price'].".00";
    $fields["WMI_CURRENCY_ID"]    = $currency;
    $fields["WMI_PAYMENT_NO"]     = $order;
    $fields["WMI_DESCRIPTION"]    = "BASE64:".base64_encode("Payment for order #".$order." in polza.com");
    $fields["WMI_EXPIRED_DATE"]   = $date_exp;
    
 
    // Сортируем переменные и декордируем их
    // Как работает код – я не знаю, взял его с документации Walletone
    foreach($fields as $name => $val) 
    {
        if (is_array($val))
        {
            usort($val, "strcasecmp");
            $fields[$name] = $val;
        }
    }
 
    uksort($fields, "strcasecmp");
    $fieldValues = "";
 
    foreach($fields as $value) 
    {
        if(is_array($value))
            foreach($value as $v)
            {
                $v = iconv("utf-8", "windows-1251", $v);
                $fieldValues .= $v;
            }
        else
        {
            $value = iconv("utf-8", "windows-1251", $value);
            $fieldValues .= $value;
        }
    }
 
    // Формируем подпись
    $signature = base64_encode(pack("H*", md5($fieldValues . $key)));
    $fields["WMI_SIGNATURE"] = $signature;
 
    // Отправляем запрос
    $agent = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)';
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_URL,'https://wl.walletone.com/checkout/checkout/Index');
    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
    curl_setopt($ch,CURLOPT_HEADER,false);
    $out=curl_exec($ch); 
    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

    // echo $out;

    // Готовим данные
    preg_match("/a href=\"(.*?)\"/", $out, $links);
    $redirect = $links[1];
    $pattern = '/amp;/s';
    $replacement = '';
    $redirect =  preg_replace($pattern, $replacement, $redirect);
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
    $pay_channel = 'walletone';
    $pay_id = $order;
    $pay_system = '0';
    $pay_amount = $_GET['price'];
    $pay_currency = $_GET['currency'];
    $status = 'new';
    $card_from = '0';
    $card_type = '0';
    $card_to = $merchant;
    $comment = '0';
    $order_id = $_GET['order'];
    $order_desc = $comment_text;

    // Записываем данные
    $date_create_sql = date("Y-m-d H:i:s", strtotime('+6 hours'));
    MySQL::query(" INSERT INTO `app_payments`( `date_create`, `pay_channel`, `pay_id`, `pay_system`, `pay_amount`, `pay_currency`, `status`, `card_from`, `card_type`, `card_to`, `comment`, `order_id`, `order_desc`) VALUES ('$date_create_sql', '$pay_channel', '$pay_id', '$pay_system', '$pay_amount', '$pay_currency', '$status', '$card_from', '$card_type', '$card_to', '$comment', '$order_id', '$order_desc' ) ");


    $time = Pulse::timer($time);
    Pulse::log($time, 'core', 'walletone_pay', 'ok', $id, $contact_id);

    // Редирект пользователя на страницу оплаты
    header('Location: https://wl.walletone.com'.$redirect.'');
 
?>