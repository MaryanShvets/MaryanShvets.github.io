<?

	ini_set('display_errors', 0);

	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Entity.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Handler.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Lead.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/vendor/Request.php');

	$apiAMO = new Handler('samoilov', 'victoriia.moskalenko@gmail.com');

	// Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $core = new API();

    // Подключаем БД
	$core->connect();

    // Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/telegram/class.php');
    $bot = new Telegram();

	$id = $_GET['id'];
	$amo_id = $core->query(" SELECT `amo` FROM `app_leads` WHERE `id` = '$id' LIMIT 1 ");
	$amo_id = $amo_id['amo'];

	$request_get_lead = new Request(Request::GET, ['id' => $amo_id], ['leads', 'list']);
	$apiAMO->request($request_get_lead)->result;
	$lead_exists = ($apiAMO->result) ? $apiAMO->result->leads[0] : false;

	if ($lead_exists) {
	    $lead = new Lead();
	    $lead
	        ->setUpdate($lead_exists->id, $lead_exists->last_modified + 1)
	        ->setResponsibleUserId($lead_exists->responsible_user_id)
	        ->setPrice($lead_exists->price)
	        ->setName($lead_exists->name)
	        ->setStatusId($apiAMO->config['LeadStatusFullPayed']);
	}
	$apiAMO->request(new Request(Request::SET, $lead));

?>