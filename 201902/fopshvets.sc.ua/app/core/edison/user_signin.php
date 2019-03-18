<?

session_start();
session_write_close();

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

$email = $_POST['email'];
$pass = $_POST['pass'];

if (empty($email) || empty($pass)) {
	echo 'empty';
	$pulse['status'] = 'ok';
	$bot_text = 'пустые поля при входе';
}
else{
	$user_check = $api->query(" SELECT *  FROM `app_users` WHERE `email` = '$email' AND `pass` = '$pass' LIMIT 1 ");

	if (!empty($user_check['id']) ) {

		$id = $user_check['id'];
		setcookie('user', $id,time()+36000, '/');
		echo 'ok';
		$pulse['status'] = 'ok';

		$bot_text = 'вход в APP пользователя '.$email;

	}else{
		echo 'wrong';
		$pulse['status'] = 'wrong';
		
		$bot_text = 'неудачная попытка входа '.$email;
	}
}

$time = Pulse::timer($time);
Pulse::log($time, 'edison', 'user_signin', $pulse['status'], $email, $pass);

?>