<?

/* Задача – OWmBfESp

Суть задачі,

Буде файл спредшит, в якому буде 1 вкладка, 1 скріпт.

Також буде створений новий endpoint (лінк в простонароді), через який можливо буде отримати реєстрації з параметрами

– номер
– дата
– емейл
– номер продукту
– utm_source
– utm_campaign
– utm_medium
– utm_content

До цього ендпоінту можливо додати параметри для фільтрафії відображення:
– дата початку (date from)
– дата кінця (date to)



Array
(
    [id] => 74181
    [contact] => 44923
    [amo] => 0
    [status] => 1
    [manager] => 
    [prepayments] => 
    [statusgr] => 
    [data] => 2018-09-18 06:50:26
    [dateofchange] => 
    [eautopay] => 
    [utmsourse] => finemail
    [utmmedium] => 0
    [utmcampaing] => 0
    [utmterm] => 0
    [utmcontent] => 0
    [product] => 401
    [id_metric] => 
    [affilate] => 0
    [getCourse] => 
)

*/


include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

$product = $_GET['product'];
$datefrom = $_GET['datefrom'].' 00:00:01';
$dateto = $_GET['dateto'].' 23:59:59';

$data = mysql_query(" SELECT * FROM `app_leads` WHERE `product` = '$product' AND `data` >= '$datefrom' AND `data` <= '$dateto' ORDER BY `app_leads`.`id`  DESC LIMIT 10000 ") or die(mysql_error());

$n = 0;
while ($row = mysql_fetch_array($data)) {
	$data_array[$n]['id'] = $row['id'];
	$data_array[$n]['contact'] = $row['contact'];
	$data_array[$n]['product'] = $row['product'];
	$data_array[$n]['data'] = $row['data'];
	$data_array[$n]['utmsourse'] = $row['utmsourse'];
	$data_array[$n]['utmmedium'] = $row['utmmedium'];
	$data_array[$n]['utmcampaing'] = $row['utmcampaing'];
	$data_array[$n]['utmcontent'] = $row['utmcontent'];
	$n++;
}

echo json_encode($data_array);

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'google_get_webfunnel', '0', '0', $id);

// http://polza.com/app/core/google/get_webfunnel?product=401&datefrom=2018-09-12&dateto=2018-09-18
 
?>