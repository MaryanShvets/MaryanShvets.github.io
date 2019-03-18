<?

// polza.com/app/core/affilate/user_mask?client=33

if (empty($_COOKIE['user']) ) 
{
	header('Location: http://polza.com/app/edison');
	die();
}

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

MySQL::connect();

$id = $_GET['client'];

$contact = MySQL::query(" SELECT * FROM `app_contact` WHERE `id` = '$id' LIMIT 1 ");
$contact_id = $contact['id'];
$contact_email = $contact['email'];

$sign_check = time().$contact_id.'|'.$contact_email.'|itsfuckinggreat';
$token = md5($sign_check);

MySQL::query(" INSERT INTO `app_affilate_tokens`(`token`, `client_id`, `client_email`) VALUES ('$token', '$contact_id', '$contact_email') ");

setcookie('affilate_user', $token, time()+2400, '/');
header('Location: http://polza.com/app/affilate');

?>