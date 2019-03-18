<?php
 
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/access.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/curl.php');

    $time = Pulse::timer(false);

    // Подключаем БД
    MySQL::connect();

    $fin_data = Access::finance('random','walletone');

    // Информация с кабинета Walletone
    $merchant = $fin_data['key1'];
    $key = $fin_data['key2'];
 
    // Готовим данные
    $fields = array(); 
    $invoice_id = $_GET['id'];
    $invoice_info = MySQL::query(" SELECT * FROM `app_payments` WHERE `id` = '$invoice_id' LIMIT 1 ");
    $order = $invoice_id.'-'.time();

    // Форматируем валюту оплаты в международный код
    if($invoice_info['pay_currency']=='UAH'){ $currency ='980'; }
    if($invoice_info['pay_currency']=='RUB'){ $currency ='643'; }
    if($invoice_info['pay_currency']=='USD'){ $currency ='840'; }
    if($invoice_info['pay_currency']=='EUR'){ $currency ='978'; }

    $date_exp = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+30, date("Y"))).'T23:59:59';
    $fields["WMI_MERCHANT_ID"]    = $merchant;
    $fields["WMI_PAYMENT_AMOUNT"] = $invoice_info['pay_amount'].".00";
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

    // Готовим данные
    preg_match("/a href=\"(.*?)\"/", $out, $links);
    $redirect = $links[1];
    $pattern = '/amp;/s';
    $replacement = '';
    $redirect =  preg_replace($pattern, $replacement, $redirect);
    $pay_channel = 'walletone';
    $pay_id = $order;
    $pay_system = '0';
    $pay_amount = $invoice_info['pay_amount'];
    $pay_currency = $invoice_info['pay_currency'];
    $status = 'active';
    $card_from = '0';
    $card_type = '0';
    $card_to = $merchant;
    $comment = '0';
    $order_desc = $comment_text;

    // Записываем данные
    $date_mod = date("Y-m-d H:i:s", strtotime('+7 hours'));
    MySQL::query(" UPDATE `app_payments` SET `pay_system`='$pay_system', `pay_id`='$pay_id',`status`='$status',`card_from`='$card_from',`card_type`='$card_type', `date_mod`='$date_mod' WHERE `id` = '$invoice_id' ");   


    $time = Pulse::timer($time);
    Pulse::log($time, 'core', 'walletone_invoice', 'ok', $pay_id, $invoice_id);
    // Редирект пользователя на страницу оплаты
    header('Location: https://wl.walletone.com'.$redirect.'');
 
?>