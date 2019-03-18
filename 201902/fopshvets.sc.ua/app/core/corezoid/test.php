<?

ini_set('display_errors', 1);

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');


include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');

Slack::personal('levchenkovic', 'Я помітив %0A спробу зареєструватись %0A з неіснуючої сторінки');



// $CZ->add_task($ref1, $process_id, $task1);
// $res = $CZ->send_tasks();

?>