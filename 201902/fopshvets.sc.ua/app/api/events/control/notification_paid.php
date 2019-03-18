<?

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
$api = new API();

session_start();

// Подключаем БД
$api->connect();

$payment = $api->query(" SELECT `id`  FROM `app_payments` WHERE `status` = 'success' ORDER BY `app_payments`.`date_mod` DESC LIMIT 1 ");

$id = $payment['id'];

if($id !== $_SESSION["OLD_id7"]) {

	$_SESSION["OLD_id7"] = $id;

	echo '<audio controls="controls" autoplay>
	               <source src="http://polza.com/media/TypingIM.wav" type="audio/wav">
	               <embed src="http://polza.com/media/TypingIM.wav">
	               Your browser is not supporting audio
	      </audio>';

	echo $id.' '.$_SESSION["OLD_id6"];
}else{
	echo 'old';
}
// SELECT `id`  FROM `app_payments` WHERE `status` = 'success' ORDER BY `app_payments`.`date_mod` DESC LIMIT 1

?>