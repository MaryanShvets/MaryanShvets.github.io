<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');

$time = Pulse::timer(false);
MySQL::connect();

$data = mysql_query(" SELECT * FROM `app_affilate_payments` WHERE `status` = '3' AND `parent_status` = '0' LIMIT 10 ");

while ($row = mysql_fetch_array($data))
{
	$status = $row['status'];
	$affilate = $row['affilate'];

	$contact = MySQL::query(" SELECT `id`, `affilate` FROM `app_contact` WHERE `id` = '$affilate' LIMIT 1 ");

	if ($contact['affilate'] !== '0') 
	{
		// echo $contact['affilate'];

		$child_id = $row['id'];
		$type = 'p_'.$row['type'];
		$product_name = 'Комиссия второго уровня за продукт '.$row['product_name'];
		$sub_id = $row['sub_id'];
		$amount = $row['amount'] * 0.1;
		$parent_id = $contact['affilate'];		
		$product = $row['product'];

		echo 'For payment '.$child_id.' found parrent with id '.$parent_id.' and comission '.$amount.' USD';

		// change child
		mysql_query( " UPDATE `app_affilate_payments` SET `parent_status`='1' WHERE `id` = '$child_id' LIMIT 1 " );

		// create parent
		mysql_query(" INSERT INTO `app_affilate_payments`( `status`, `parent_status`, `child_id`, `type`, `product`, `product_name`, `sub_id`, `amount`, `currency`, `affilate`) VALUES ('2', '3', '$child_id', '$type', '$product', '$product_name', '$sub_id', '$amount', 'USD', '$parent_id') ");
	}
	else
	{
		$child_id = $row['id'];
		mysql_query( " UPDATE `app_affilate_payments` SET `parent_status`='2' WHERE `id` = '$child_id' LIMIT 1 " );
	}
}

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_regular_affilate_parentsearch', '0', '0', '0');

// app_affilate_payments.status
// 0 - не перевірено
// 1 - не підтверджений
// 2 - підтверджений
// 3 - виплачено
// 4 - відхилено
// 
// app_affilate_payments.parent_status
// 0 - не перевірено
// 1 - знайдено партнера 2 рівня
// 2 - не має партнера 2 рівня 
// 3 - вже є партнером 2 рівня
// 
// app_affilate_payments.child_id
// 0 - якщо це платіж для 2 рівня
// 1 - з якого платежу 1 рівня це комісія
// 
// app_contact.affilate_status
// 0 - не підтрведжений
// 1 - підтверджений
// 
// polza.com/app/core/events/regular_affilate_parentsearch

?>