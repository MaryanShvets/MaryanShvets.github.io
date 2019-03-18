<?

ini_set('display_errors', 0);

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/email.php');

$time = Pulse::timer(false);




// polza.com/app/core/events/funnel_speedreg?e=%EMAIL%&p=371

?>