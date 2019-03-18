<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');

$time = Pulse::timer(false);

MySQL::connect();


$time = Pulse::timer($time);
// Pulse::log($time, 'core', 'events_paid_invoice', '0', '0', $id);

?>