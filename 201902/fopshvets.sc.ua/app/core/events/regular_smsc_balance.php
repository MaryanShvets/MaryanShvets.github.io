<?

ini_set('display_errors', 1);
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/todoist.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');

$time = Pulse::timer(false);

$controller = 'controller_smsc';
$memory = Memory::load($controller);

$url = 'https://smsc.ru/sys/balance.php?login=polzacom&psw=Molotok2017!!&fmt=3';
$data = file_get_contents($url);
$data = json_decode($data, true);
$balance = $data['balance'];
$balance = round($balance);

$new_memory = array();


if ($balance <= 3000 && $balance >= 1001) {

	if ($memory['notification'] == 'no') {

		Slack::general('🚨 Баланс SMSC меньше 3000 рублей. Пополните счет.');
		
		$new_memory['notification'] = 'yes';
		$new_memory['remind'] = 'no';

		Memory::save($controller, $new_memory);
	}

}elseif($balance <= 1000){

	if ($memory['remind'] == 'no') {

		Slack::general('🚨 Баланс SMSC на опасном уровне. Обязательно пополните счет');
		
		$new_memory['notification'] = 'yes';
		$new_memory['remind'] = 'yes';

		Memory::save($controller, $new_memory);
	}
}
elseif($memory['remind']=='yes' && $memory['notification']=='yes' && $balance >=3000){

	Slack::general('✅ Баланс SMSC на нормальном уровне и составляет '.$balance.' рублей');

	$new_memory['notification'] = 'no';
	$new_memory['remind'] = 'no';

	Memory::save($controller, $new_memory);
}

Pulse::log(Pulse::timer($time), 'core', 'events_regular_smsc_balance', '0', '0', $balance);

?>