<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/email.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/sms.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');


// http://polza.com/app/core/activecampaign/tag_add

echo '<pre>';

// Email::tag_add('money_plus1_wait', 'aleks.m.roschyn@gmail.com');
// echo Email::info('2');
echo '</pre>';

// https://www.activecampaign.com/api/example.php?call=contact_sync

// $data['student'] = $_POST['student']['email'];

// Email::update_fast($data['student'], $_GET['list']);

// $time = Pulse::timer($time);
// Pulse::log($time, 'core', 'antitreningi_callback', 'email_list', $_GET['list'] , $data['student']);

?>