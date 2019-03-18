<?

// Отображение ошибок (1 – показывать, 0 – скрывать)
ini_set('display_errors', 1);

// $site = 'http://polza.com/app/api/payment/config/get_keys.php';
// $site.= '?system=fondy';
// $data = json_decode(file_get_contents($site));

// echo $data['key1'];


// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
$api = new API();
// Подключаем БД
$api->connect();

$fin_data = $api->get_fin('fondy');

// Готовим данные
$merchant_id = $fin_data['key1'];
$merchant_pass = $fin_data['key2'];

echo $merchant_id;
echo $merchant_pass;


?>