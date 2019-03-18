<?

// 
// http://polza.com/app/core/events/chatfuel_broadcast?email=vl@polza.com&bot=kir&block=5aba34c9e4b0fbbd9e60873e

ini_set('display_errors', 1);

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');

$time = Pulse::timer(false);

$email = $_GET['email'];
$block = $_GET['block'];
$bot = $_GET['bot'];

$memory = Memory::load('bots_config');

MySQL::connect();

$contact = MySQL::query(" SELECT * FROM `app_bot_list` WHERE `email` = '$email' LIMIT 1 ");

if ($contact['messenger'] !== '0' ) 
{
	$chatfuel = $contact['messenger'];
	$token = $memory[$bot]['token'];

	$url = 'https://api.chatfuel.com/bots/'.$memory[$bot]['id'].'/';
	$url.= 'users/'.$chatfuel.'/send?chatfuel_token='.$token.'&chatfuel_block_id='.$block;


	$ch=curl_init();
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	    curl_setopt($ch,CURLOPT_URL,$url);
	    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
	    curl_setopt($ch,CURLOPT_HEADER,false);
	$out=curl_exec($ch); 
	$code=curl_getinfo($ch,CURLINFO_HTTP_CODE);


	echo $out.'<br>';
	echo $code;

	$status = 'found';
}
else
{
	$status = 'notfound';
	$code = '0';
}


$time = Pulse::timer($time);
Pulse::log($time, 'core', 'event_chatfuel_broadcast', $code, '0', $email);

?>