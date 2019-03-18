<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');

MySQL::connect();


function slow($name, $time)
{
	switch ($name) 
	{
		case 'activecampaign_webhook':
		case 'events_funnel_lms_delete':
		case 'events_paid_auto':
		case 'events_regular_smsc_balance':
		case 'fondy_callback':
		case 'google_get_rates':
		case 'google_get_sales':
		case 'lib_slack':
		case 'user_signin':

				if ($time > 10)  { return true; }
				else { return false; }

			break;
		
		default:
				
				if ($time > 2)  { return true; }
				else { return false; }

			break;
	}
}

$yesterday = date("Y-m-d", strtotime('+6 hours'));
$yesterday = date("Y-m-d", strtotime('-1 days'));
$yesterday = $yesterday.' 00:00:01';

$today = date("Y-m-d", strtotime('+6 hours'));
$today = $today.' 00:00:01';
$yesterday = mysql_query(" SELECT `key2` as `service`, COUNT(*) as `count`, ROUND(AVG(`time`),2) as `time`  FROM `app_pulse` WHERE `datetime` >= '$yesterday' AND `datetime` <'$today' AND `key2` !='events' GROUP BY `service` ORDER BY `count`  DESC ");

$bot_text = '<b>Звіт системи за '.date("d.m.Y", strtotime('-1 days')).'</b>';
$bot_text.= "\n";

$bad = 0;
$good = 0;

while ($row = mysql_fetch_array($yesterday)) 
{
	$bot_text.= "\n";

	if (slow($row['service'], $row['time']) == true) 
	{
		$bot_text.= '❤️ <b>'.$row['time'].' ('.$row['count'].')</b> '.$row['service'];
		$bad++;
	}
	else
	{
		$bot_text.= '💚 <b>'.$row['time'].' ('.$row['count'].')</b> '.$row['service'];
		$good++;
	}
}

$bot_text.= "\n";
$bot_text.= "\n";

$bot_text.= '💚 '.$good.' ❤️ '.$bad;

Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text, 'parse_mode'=>'html' ));

// http://polza.com/app/core/events/regular_system_report

?>