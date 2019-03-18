<?

// $card = '5169330508353031';
// $id = '120242';
// $pass = 'd163CE6Vr9zQ09v7gzn1G9Mi698n95Yd';

// $fin_data = json_decode(file_get_contents('http://polza.com/app/api/payment/config.json'));

$id = $_GET['id'];
$pass = $_GET['pass'];
$card = $_GET['card'];

$data = '<oper>cmt</oper>
    <wait>0</wait>
    <test>0</test>
    <payment id="">
      <prop name="cardnum" value="'.$card.'" />
      <prop name="country" value="UA" />
    </payment>';

$sign=sha1(md5($data.$pass));

$input_xml = '<?xml version="1.0" encoding="UTF-8"?>
<request version="1.0">
  <merchant>
    <id>'.$id.'</id>
    <signature>'.$sign.'</signature>
  </merchant>
  <data>
    <oper>cmt</oper>
    <wait>0</wait>
    <test>0</test>
    <payment id="">
      <prop name="cardnum" value="'.$card.'" />
      <prop name="country" value="UA" />
    </payment>
  </data>
</request>';

$url = "https://api.privatbank.ua/p24api/balance";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
$data = curl_exec($ch);

curl_close($ch);

$array_data = json_decode(json_encode(simplexml_load_string($data)), true);
echo $array_data['data']['info']['cardbalance']['balance'].' '.$array_data['data']['info']['cardbalance']['card']['currency'];


?>