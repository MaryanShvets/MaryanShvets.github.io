<?

// affilate_user

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');

if (!empty($_GET['token'])) 
{

	MySQL::connect();

	$token = $_GET['token'];
	$token_info = MySQL::query(" SELECT * FROM `app_affilate_tokens` WHERE `token` = '$token' LIMIT 1 ");

	if (!empty($token_info['token'])) 
	{

		setcookie('affilate_user', $token, time()+2400, '/');
		header('Location: http://polza.com/app/affilate');
	}
}
else
{
	die();
}

// polza.com/app/affilate/t/687d8abdb57460904c50bc2ef3803d9c

?>