<?
	

// Готовим данные

// echo 'ok';
$merchant_id = $_GET['id'];
$merchant_pass = $_GET['pass'];

$date_from = date("d.m.Y",mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
$date_to = date("d.m.Y",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));   

$sign_string = $merchant_pass.'|'.$date_from.'|'.$date_to.'|'.$merchant_id;
$sign=sha1($sign_string);

$request = '{
	  "request": {
	    "merchant_id": "'.$merchant_id.'",
	    "date_from": "'.$date_from.'",
	    "date_to": "'.$date_to.'",
	    "signature": "'.$sign.'"
	  }
	}';

// Отправляем запрос
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.fondy.eu/api/reports/");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$request);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = json_decode(curl_exec ($ch), JSON_OBJECT_AS_ARRAY);
curl_close ($ch);

$output = $output['response'];

$summ = 0;

foreach ($output as $key => $value) {

	if ($value['settlement_amount'] == 0 && $value['response_status']=='success' ) {
		$amount = $value['actual_amount'];
		$fee = $value['fee_oplata'];

		$amount = round($amount / 100);
		$fee = round($fee / 100);
		$amount = $amount - $fee;

		$summ = $summ + $amount;
	}
	
}

echo $summ;

?>