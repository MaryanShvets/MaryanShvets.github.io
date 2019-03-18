<?

ini_set('display_errors', 1);

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/sms.php');

$time = Pulse::timer(false);

$user_id = $_POST['user_id'];
$email = $_POST['email'];
$bot = $_POST['bot'];

MySQL::connect();

mysql_query(" DELETE FROM `app_bot_list` WHERE `email` = '$email' AND `bot` = '$bot' ");
mysql_query(" INSERT INTO `app_bot_list` (`email`, `messenger`, `bot`) VALUES ('$email','$user_id','$bot') ");

if ($_POST['message'] !== '0') 
{
	file_get_contents('http://polza.com/app/core/events/chatfuel_broadcast?email='.$email.'&block='.$_POST['message'].'&bot='.$bot);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>polza.com</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
</head>
<body style="font-family: sans-serif;font-size: 20px;width: 600px;margin: auto;">

	<center style="margin-top: 30px;">

		<?
		echo 'Получилось! <br> Профиль Facebook привязан к почте '.$email;
		?>

	</center>

</body>
</html>

<?

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_chatfuel_changed', $bot, $email, $user_id);

?>