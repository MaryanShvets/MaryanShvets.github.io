<?

	header('Access-Control-Allow-Origin: *'); 
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 0); 

	// Подключаем основной клас
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

    // Подключаем Telegram бота
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
    $bot = new Slack();

    // Подключаем набор функций с AmoCRM (нужно только для возврата ID добавленого лида)
    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/control/basic.php');

    // Подключаем БД
	$api->connect();

    $bot->say_test('Запрос к файлу отправки формы');

    // Получаем POST с формы
	$data = $_POST;

    // Готовим даные
    if(empty($data['name'])){$form_name=' ';}else{$form_name = $data['name'];}
    if(empty($data['phone'])){$form_phone='0';}else{$form_phone = $data['phone'];}
    if(!empty($data['email'])){$form_email = $data['email'];}else{die;}
	$utm_medium='0';
	$utm_source='0';
	$utm_campaign='0';
	$utm_term='0';
	$utm_content='0';


	$source = $_POST['formid'];
    $product = $api->query(" SELECT * FROM `products` WHERE `URL` = '$source' LIMIT 1 ") or die(mysql_error());

    if (empty($product['id'])) {

        $bot_text = 'Не найдена страница по форме '.$source;
        $bot->say_test($bot_text);
    }


    $product_id = $product['id'];

    // Если нашли такой продукт
    if(!empty($product)){

    	// Ищем контакт по почте
    	$contact_email = $data['email'];
    	$contact = $api->query(" SELECT * FROM `app_contact` WHERE `email` = '$contact_email' LIMIT 1 ");

    	// Если контакт уже есть
    	if (!empty($contact)) {
    		$contact_id = $contact['id'];

    	// Если контакт новый – создаем его
    	}else{
    		$api->query(" INSERT INTO `app_contact`( `name`, `email`, `phone`) VALUES ('$form_name', '$form_email' ,'$form_phone' ) ");
    		$contact_id = mysql_insert_id();
    	}

    	// Отправка СМС (если включено)
    	if($product['smsview']=='1'){
    		$api->send_sms($product['SmS'], $form_name, $form_phone);
    	}

        // Новая сделка в AmoCRM
        $lead_id = '0';
        $lead_status = '1';

        // Добавляем заявку в AmoCRM (если включено)
        // if($product['amoview']=='1'){

        //     $lead = $api->query(" SELECT `id` FROM `app_leads` WHERE `contact` = '$contact_id' AND `product` = '$product_id' LIMIT 1 ");

        //     $submit_id = $lead['id'];

        //     if(empty($lead)){
                
        //         $amo_utm = $utm_source.'>'.$utm_medium.'>'.$utm_term.'>'.$utm_content.'>'.$utm_campaign;

        //         $lead_id = amo_add_lead($form_name, $form_phone, $form_email, $product['amoName'], $product['amoTags'], $product['amoPrice'], $amo_utm);
        //         // $lead_id = $api->add_lead($form_name, $form_email, $form_phone, $product['amoName'], $product['amoTags'], $product['amoPrice'], $amo_utm);
        //         $lead_status = '7080818';

        //         // Отправляем сообщение в Telegram 
        //         $bot_text = '✅  '.$product['amoName'];
        //         if($utm_source!=='0'){ $bot_text.=' / '.$utm_source; }

        //         $bot_text.= ' / '.$form_email;
                
        //         $bot->say($bot_text);

        //     }else{
        //         $lead_uniq = '1';
        //     }
        // }  
         
    	// Добавить до списка ActiveCampaign (если включено)
    	if($product['grview']=='1'){

            // Отправляем сообщение в Telegram 
            if($product['amoview']=='0'){
                $bot_text = '📬  '.$product['amoName'];
                if($utm_source!=='0'){ $bot_text.=' / '.$utm_source; }
                $bot_text.=' / '.$form_email;
                $bot->say($bot_text);
            }

            $api->add_email($data['email'], $form_name, $form_phone, $product['grNew'] );
    	}

        // Если это уникальная регистрация – добавляем ее
        if ($lead_uniq == '0') {
            $submit = $api->query(" INSERT INTO `app_leads`( `contact`, `amo`, `status`, `utmsourse`, `utmmedium`, `utmcampaing`, `utmterm`, `utmcontent`, `product`) VALUES ('$contact_id', '$lead_id', '$lead_status', '$utm_source', '$utm_medium', '$utm_campaign', '$utm_term', '$utm_content', '$product_id' ) ");
            $submit_id = mysql_insert_id();
        }

    	$response['status']='success';
    	$response['redirect'] = $product['redirect'].'?name='.$form_name.'&email='.$form_email.'&phone='.$form_phone.'&id='.$submit_id;
    	echo json_encode($response);

    // Если не нашли
    }else{
    	

    }

	// $string = $_POST['tranid'];
	// $pattern = '/(.*?):(.*?)/is';
	// $replacement = '$1';
	// echo preg_replace($pattern, $replacement, $string);

	// $subject = $_POST['tranid'];
	// $pattern = '/(.*?):(.*?)/is';
	// preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE);
	// // print_r($matches);

	// $fp = fopen('callback.txt', 'a');
	// fwrite($fp, $matches[0] . PHP_EOL);
	// fclose($fp);

			// $source = '199075:2160381';
			// $pattern = '/(.*?)ID(.*?)\.html\z/s';
			// $replacement = '$2';
			// $out = preg_replace($pattern, $replacement, $source);

	// $data = $_POST['tranid'];
	// preg_match( '/(.*?):/is', $data, $out);
	// $out = $out[1];

	

	// // echo 'ok2';

	// // Подключаем Telegram бота
 //    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/slack/class.php');
 //    $bot = new Slack();

 //    $text = $_POST['email'].' / '.$_POST['name'].' / '.$_POST['phone'];

 //    $bot->say_pers('levchenkovic', $text);

 //    // Редиректим пользователя на оплату
	// header('Location: http://polza.com');
?>