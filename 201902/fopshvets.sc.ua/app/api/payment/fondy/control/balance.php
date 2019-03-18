<?
    ini_set('display_errors', 1);

    $merchant_id = $_GET['id'];
    $merchant_pass = '7zwgt2L2srYH2Vy0ao39SxQ1D4Sqj4Bw';
    $date_from = date("d.m.Y",mktime(0, 0, 0, date("m")-1  , date("d"), date("Y")));
    $date_to = date("d.m.Y");

    echo $merchant_id.'<br>';
    echo $date_from.'<br>';
    echo $date_to.'<br><br>';

    $sign_string = $merchant_pass.'|'.$date_from.'|'.$date_to.'|'.$merchant_id;
    $sign = sha1($sign_string);

    $request = '{
      "request": {
        "date_from": "'.$date_from.'",
        "date_to": "'.$date_to.'",
        "merchant_id": "'.$merchant_id.'",
        "signature": "'.$sign.'"
      }
    }';

    echo $request;

    echo '<br>';
    echo '<br>';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.fondy.eu/api/reports/");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS,$request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = json_decode(curl_exec ($ch));
    curl_close ($ch);

    echo '<pre>';
    print_r($output);

    // polza.com/app/api/payment/fondy/control/balance.php

?>