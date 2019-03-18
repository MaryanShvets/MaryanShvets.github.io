<?


ini_set('display_errors', 1);
header('Content-Type: application/json');
$remote = $_SERVER['REMOTE_ADDR'];
$server = $_SERVER['SERVER_ADDR'];

// if($remote == $server){

	// Подключаем основной клас
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	$api = new API();

	// Подключаем Telegram бота
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
	$bot = new Slack();

	// Подключаем БД
	$api->connect();

	$system = $_GET['system'];

	$sql_request = " SELECT * FROM `app_payments_config` ";
	$sql_request.= " WHERE `system` = '".$system."' AND `status` = 'active' ";
	$sql_request.= " ORDER BY RAND () LIMIT 1 ";

	$fin_data = $api->query($sql_request);

	$data_array['key1'] = $fin_data['key1'];
	$data_array['key2'] = $fin_data['key2'];
	$data_array['key3'] = $fin_data['key3'];

	echo json_encode(array('status'=>'success', 'data' => $data_array));

	// echo json_encode(array(
	// 		'key1'=>$fin_data['key1'],
	// 		'key2'=>$fin_data['key2'],
	// 		'key3'=>$fin_data['key3']
	// 	));


	// print_r($data);

// }else{
// 	echo 'no access';
// }

?>