<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');

$bot_text = 'login ';

if (!empty($_POST['email'])) 
{
	$contact_email = $_POST['email'];
}
else
{
	die();
}


MySQL::connect();

$contact = MySQL::query(" SELECT * FROM `app_contact` WHERE `email` = '$contact_email' LIMIT 1 ");

$contact_id = $contact['id'];

if ($contact_id == 0) {
	
	echo 'notfound';
	die();
}
else
{
	echo 'ok';
}

$sign_check = time().$contact_id.'|'.$contact_email.'|itsfuckinggreat';
$token = md5($sign_check);

$token_check = MySQL::query(" SELECT COUNT(token) as `count` FROM `app_affilate_tokens` WHERE `token` = '$token' ");


if ($token_check['count'] == '0') 
{
	MySQL::query(" INSERT INTO `app_affilate_tokens`(`token`, `client_id`, `client_email`) VALUES ('$token', '$contact_id', '$contact_email') ");

	$subject = 'Вход в Polza Affilate';

	$headers = "From: Polza <noreply@polza.com>\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	$message .= '
	<div style="    width: 100%;
	    background: #eceff1;
	    font-family: sans-serif;
	    display: inline-block;">
		<div style="background-color:#ffffff;width:90%;max-width:600px;margin:auto;border-radius:3px;padding-bottom:30px;margin-top:35px;margin-bottom:35px"><h1 style="border-bottom:1px solid #01bfa5;font-size:24px;padding-bottom:20px;text-align:center;padding-top:15px;padding-left:15px;padding-right:15px;font-weight:normal">Вход в Polza Affilate</h1>
	    
				<center><a href="http://polza.com/app/affilate/t/'.$token.'" style="background:#01bfa5;font-weight:200;border-radius:3px;/* padding:10px 15px; */color:white;width:auto;text-align:center;margin-left:15px;margin-right:15px;/* padding-left:50px; *//* padding-right:50px; */font-size:22px;text-decoration:none;display:inline-block;width: 70%;margin-left: auto;margin-right: auto;padding-top: 10px;padding-bottom: 10px;">Войти</a></center></div>
					<div style="text-align:center; font-size:12px; padding-bottom:20px; padding-top:20px;" class="col-md-12 text-center fs-12 pb-20">
				        © polza.com Все права защищены. <a target="_blank" href="http://pages.polza.com/publichnyiy-dogovor">Публичный договор</a>.<br>
				        По всем вопросам: team@mail.polza.com
				      </div>
				</div>

		';

		mail($contact_email, $subject, $message, $headers);
}


// Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));		

?>