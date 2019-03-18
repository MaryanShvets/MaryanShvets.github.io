<?

ini_set('display_errors', 0);

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/email.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/corezoid.php');

$time = Pulse::timer(false);

// $corezoid_api_login = '85208';
// $corezoid_api_secret = 'Wk83zM9Ah4fVsat8srvPUgEa2uO4uj6W5CxZ4xokfMa8JMgZ6m';

// $CZ = new Corezoid($corezoid_api_login, $corezoid_api_secret);

// Подключаем БД
MySQL::connect();

// Присваеваем переменные
$email = $_GET['e'];
$product_id = $_GET['p'];

// Получаем данные по продукту
$product = MySQL::query(" SELECT `grNew`, `redirect`, `amoName` FROM `products` WHERE `id` = '$product_id' LIMIT 1 ");

// Подписываем емейл на нужный список
Email::update_fast($email, $product['grNew'] );

// Записываем лог
$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_funnel_speedreg', $product['grNew'], $product_id, $email);

$bot_text = '📬  '.$product['amoName'];
$bot_text.=' / '.$email;

// $ref1    = time().'_'.rand();
// $task1   = array(
	// 'text' => $bot_text
// );

// $process_id = 294168;

// $CZ->add_task($ref1, $process_id, $task1);
// $res = $CZ->send_tasks();

Slack::report($bot_text);

// Направляем пользователя на страницу «спасибо»
header('Location: '.$product['redirect']);


// polza.com/app/core/events/funnel_speedreg?e=%EMAIL%&p=371

// http://polza.acemlnb.com/lt.php?notrack=1&s=8c696a7d5755ad5b8b79b00337efc7fb&i=519A823A121A30579

?>