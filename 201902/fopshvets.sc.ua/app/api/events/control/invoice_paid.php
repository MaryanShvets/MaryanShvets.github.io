<?

	// Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

    $time = $api->pulse_timer(false);

    // Подключаем БД
	$api->connect();

    // Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/telegram/class.php');
    $bot = new Telegram();

    // Подключаем набор функций с AmoCRM
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/control/basic.php');

    // Получаем ID оплаты
	$id = $_GET['id'];

    $payment = $api->query(" SELECT * FROM `app_payments` WHERE `order_id` = '$id' LIMIT 1 ");

	// Ставим задачу менеджеру, что счет оплачен
	amo_add_task($id, 'Счет оплачен');

    $bot_text = 'Оплачен счет №'.$id.' ('.$payment['order_desc'].', '.$payment['pay_amount'].' '.$payment['pay_currency'].')';
   
    $bot->say_pers('oleksandr.roshchyn',$bot_text);
    $bot->say_pers('rtf',$bot_text);
    $bot->say_pers('levchenkovic',$bot_text);

    // $bot_text = 'оплата счета с номером '.$id;
    // $bot->say_test($bot_text);

    $time = $api->pulse_timer($time);
    $api->pulse_log($time, 'api', 'events', 'invoice_paid', '0', $id);

?>