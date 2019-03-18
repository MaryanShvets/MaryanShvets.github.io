<?

// http://polza.com/app/core/events/chatfuel_login?user_id=
// http://polza.com/app/core/events/chatfuel_login?user_id={{messenger_user_id}}
// http://polza.com/app/core/events/chatfuel_login?user_id=1194205337357191

ini_set('display_errors', 1);

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/sms.php');

$time = Pulse::timer(false);

// Подключаем БД
MySQL::connect();

$user_id = $_GET['user_id'];
$bot = $_GET['bot'];

if (empty($user_id)) {
	die();
}

if (empty($_GET['message'])) 
{
	$message = '0';
}
else
{
	$message = $_GET['message'];
}


$contact = MySQL::query(" SELECT * FROM `app_bot_list` WHERE `messenger` = '$user_id' AND `bot` = '$bot' LIMIT 1 ");
$contact_chatfuel = $contact['messenger'];
$contact_email = $contact['email'];

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

			if (!empty($contact_email)) {
				echo 'Facebook аккаунт привязан к почте '.$contact_email.'<br>';
			}

		?>

		<form action="/app/core/events/chatfuel_changed" method="POST">
			<input type="text" name="email" placeholder="Email" required="true" style="display: inline-block; padding: 10px 10px; box-sizing: border-box; border: 1px solid rgb(223, 223, 223); border-radius: 4px; font-size: 16px; font-weight: 100; transition: all 0.5s; width: 100%; margin-top: 30px;">
			<input type="hidden" name="user_id" value="<?=$user_id?>">
			<input type="hidden" name="message" value="<?=$message?>">
			<input type="hidden" name="bot" value="<?=$bot?>">
			<br>
			<input type="submit" style="border-radius: 4px;padding: 10px 10px;box-sizing: border-box;margin: 5px 0px;border: 1px solid #0f82f6;background: #0f82f6;color: white;width: 100%;font-size: 20px;">
		</form>

	</center>

</body>
</html>

<?

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_chatfuel_login', '0', '0', $user_id);

?>