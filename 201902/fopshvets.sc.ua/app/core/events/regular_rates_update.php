<?

ini_set('display_errors', 1);
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');

$data = file_get_contents('https://openexchangerates.org/api/latest.json?app_id=5d631e7cabf947428f800341eb8804f5&base=USD&symbols=RUB,UAH');
$data = json_decode($data, true);


if (!empty($data['rates'])) 
{
	$data = $data['rates'];
	Memory::save('rates',$data);
}
else
{
	Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>'🚨 Не удалось обновить курс валют' ));	
}

// 'https://openexchangerates.org/api/latest.json?app_id=5d631e7cabf947428f800341eb8804f5';

?>