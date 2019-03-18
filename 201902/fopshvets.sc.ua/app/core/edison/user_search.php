<?

session_start();
session_write_close();

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

if (empty($_GET['email'])) {
	
	echo '<p>Не вижу емейла</p>';
	die();
}else{
	$email = $_GET['email'];
}

$contact = MySQL::query(" SELECT `id` FROM `app_contact` WHERE `email` = '$email' LIMIT 1");
$contact_id = $contact['id'];

echo '<br>';

$submits = mysql_query(" SELECT * FROM `app_leads` WHERE `contact` = '$contact_id' ORDER BY `app_leads`.`id` DESC") or die(mysql_error());
echo '<h1>Заявки:</h3>';


echo '<br>';

while ($row = mysql_fetch_array($submits)) {
	
	$product_id = $row['product'];
	$product = MySQL::query(" SELECT `amoName` FROM `products` WHERE `id` = '$product_id' LIMIT 1");

	echo '<div class="items">'.$row['data'].' была заявка '.$product['amoName'].'<br> utm_source '.$row['utmsourse'].' <br>utm_medium '.$row['utmmedium'].' <br>utm_campaigh '.$row['utmcampaing'].' <br>utm_term '.$row['utmterm'].'</div>';
}

echo '<br>';


$payments = mysql_query(" SELECT * FROM `app_payments` WHERE `order_id` IN (SELECT `id` FROM `app_leads` WHERE `contact` in( SELECT `id` FROM `app_contact` WHERE `email` = '$email')) AND `type` = 'payment'") or die(mysql_error());
echo '<h1>Платежи:</h3>';

echo '<br>';

while ($row = mysql_fetch_array($payments)) {

	echo '<div class="items">'.$row['date_create'].' создан платеж / '.$row['status'].'<br>'.$row['order_desc'].'</div>';
}

echo '<br>';


$invoice = mysql_query(" SELECT * FROM `app_payments` WHERE `order_id` IN( SELECT `amo` FROM `app_leads` WHERE `contact` IN ( SELECT `id` FROM `app_contact` WHERE `email` = '$email') AND `amo` !='0' ) AND `type` = 'invoice' ") or die(mysql_error());
echo '<h1>Выставленные счета:</h3>';

echo '<br>';

while ($row = mysql_fetch_array($invoice)) {

	echo '<div class="items">'.$row['date_create'].' / '.$row['status'].' / '.$row['order_desc'].'</div>';
}		

$time = Pulse::timer($time);
Pulse::log($time, 'edison', 'user_search', 'ok', '0', $_GET['email']);	

?>