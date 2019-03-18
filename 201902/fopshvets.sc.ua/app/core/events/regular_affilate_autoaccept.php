<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');

$time = Pulse::timer(false);

MySQL::connect();

$good_contact = array();

$data = mysql_query(" SELECT * FROM `app_affilate_payments` WHERE `status` = '0' LIMIT 10 ");

while ($row = mysql_fetch_array($data))
{
	$id = $row['id'];
	$status = $row['status'];
	$affilate = $row['affilate'];

	if ($good_contact[$affilate] == 1) 
	{
		$new_status = 2;
	}
	elseif($good_contact[$affilate] == 2)
	{
		$new_status = 1;
	}
	else
	{
		$contact = MySQL::query(" SELECT `affilate_status` FROM `app_contact` WHERE `id` = '$affilate' LIMIT 1 ");

		if ($contact['affilate_status'] == 0) 
		{
			// not safe
			$good_contact[$affilate] = 2;
		}
		elseif ($contact['affilate_status'] == 1) 
		{
			// is safe
			$good_contact[$affilate] = 1;
		}

		if ($good_contact[$affilate] == 1) 
		{
			$new_status = 2;
		}
		elseif($good_contact[$affilate] == 2)
		{
			$new_status = 1;
		}
	}

	if ($new_status == 1 || $new_status == 2) 
	{
		mysql_query( " UPDATE `app_affilate_payments` SET `status`='$new_status' WHERE `id` = '$id' LIMIT 1 " );
	}
} 

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_regular_affilate_autoaccept', '0', '0', '0');

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
// 
// app_affilate_payments.child_id
// 0 - якщо це платіж для 2 рівня
// 1 - з якого платежу 1 рівня це комісія
// 
// app_contact.affilate_status
// 0 - не підтрведжений
// 1 - підтверджений
// 
// polza.com/app/core/events/regular_affilate_autoaccept

?>