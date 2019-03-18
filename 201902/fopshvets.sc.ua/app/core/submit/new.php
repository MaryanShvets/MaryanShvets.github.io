<?
    
    // die();


    $http_origin = $_SERVER['HTTP_ORIGIN'];
    $allowed_domains = [
        'http://pages.polza.com',
        'https://pages.polza.com',
        'http://polza.com',
        'https://polza.com'
    ];

    if (in_array($http_origin, $allowed_domains))
    {  
        header("Access-Control-Allow-Origin: $http_origin");
        header("Access-Control-Allow-Credentials: true");
    }

	session_start();
	session_write_close();


    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/email.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/sms.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/corezoid.php');
    include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');

    $time = Pulse::timer(false);

    MySQL::connect();

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

    $lead_uniq = '0';

    $source = $_POST['formid'];

    if(empty($source)) {

        $referer = strtok($_SERVER['HTTP_REFERER'], '?');
        $product = MySQL::query(" SELECT * FROM `products` WHERE `URL` = '$referer' LIMIT 1 ");

         // Получаем UTM метки
        $parsed_url = parse_url($_SERVER['HTTP_REFERER']);
        if (!empty($parsed_url['query'])) {
           $str = $parsed_url['query'];
           parse_str($str);
        }

    }else{
        
        $source = $_POST['formid'];
        $product = MySQL::query(" SELECT * FROM `products` WHERE `URL` = '$source' LIMIT 1 ");

        if(!empty($_POST['utm_source'])){$utm_source = $_POST['utm_source'];}
        if(!empty($_POST['utm_medium'])){$utm_medium = $_POST['utm_medium'];}
        if(!empty($_POST['utm_term'])){$utm_term = $_POST['utm_term'];}
        if(!empty($_POST['utm_content'])){$utm_content = $_POST['utm_content'];}
        if(!empty($_POST['utm_campaign'])){$utm_campaign = $_POST['utm_campaign'];}

        if (empty($product['id'])) {

            // $bot_text = 'Не найдена страница по форме '.$source;
            // $bot->say_test($bot_text);
        }
    }

    

    $product_id = $product['id'];

    // Если нашли такой продукт
    if(!empty($product)){

    	// Ищем контакт по почте
    	$contact_email = $data['email'];
    	$contact = MySQL::query(" SELECT * FROM `app_contact` WHERE `email` = '$contact_email' LIMIT 1 ");

    	// Если контакт уже есть
    	if (!empty($contact)) {
    		$contact_id = $contact['id'];

    	// Если контакт новый – создаем его
    	}else{
    		MySQL::query(" INSERT INTO `app_contact`( `name`, `email`, `phone`) VALUES ('$form_name', '$form_email' ,'$form_phone' ) ");
    		$contact_id = mysql_insert_id();
    	}

        if ($_COOKIE['affilate'] !== '0' && !empty($_COOKIE['affilate'])) 
        {
            $affilate_id = $_COOKIE['affilate'];
            mysql_query(" UPDATE `app_contact` SET `affilate`='$affilate_id' WHERE `id` = '$contact_id' AND `affilate` = '0' ");
        }

    	// Отправка СМС (если включено)
    	if($product['smsview']=='1'){
    		SMS::send($product['SmS'], $form_name, $form_phone);
    	}

        // Новая сделка в AmoCRM
        $lead_id = '0';
        $lead_status = '1';

        // Добавляем заявку в AmoCRM (если включено)
        if($product['amoview']=='1'){

            // Подключаем набор функций с AmoCRM (нужно только для возврата ID добавленого лида)
            // include( $_SERVER['DOCUMENT_ROOT'].'/app/api/amocrm/control/basic.php');

            // $lead = $api->query(" SELECT `id` FROM `app_leads` WHERE `contact` = '$contact_id' AND `product` = '$product_id' LIMIT 1 ");

            // $submit_id = $lead['id'];

            // if(empty($lead)){
                
                // $amo_utm = $utm_source.'>'.$utm_medium.'>'.$utm_term.'>'.$utm_content.'>'.$utm_campaign;

                // $product['amoPrice'] = round($product['amoPrice']/56.7);

                // $lead_id = amo_add_lead($form_name, $form_phone, $form_email, $product['amoName'], $product['amoTags'], $product['amoPrice'], $amo_utm);
                $lead_id = '0';
                $lead_status = '7080818';

                // Отправляем сообщение в Telegram 
                $bot_text = '✅ '.$product['amoName'];

                if($utm_source!=='0')
                { 
                    $bot_text.=' / '.$utm_source; 
                }

                $bot_text.= ' / '.$form_email;

                if ($product['amoPrice'] == 0) 
                {
                    Slack::webfunnel($bot_text);
                }
                else
                {
                    Slack::report($bot_text);
                }
                
                // Slack::report($bot_text);

                // $ref1    = time().'_'.rand();
                // $task1   = array(
                //  'text' => $bot_text
                //  );

                // $process_id = 294168;

                // $CZ->add_task($ref1, $process_id, $task1);

                // $corezoid_time = Pulse::timer(false);
                // $res = $CZ->send_tasks();
                // Pulse::log(Pulse::timer($corezoid_time), 'core', 'corezoid', 'slack', '0', '0');

                Slack::report($bot_text);

            // }else{
            //     $lead_uniq = '1';
            // }
        }  
         
    	// Добавить до списка ActiveCampaign (если включено)
    	if($product['grview']=='1'){

            // Отправляем сообщение в Telegram 
            if($product['amoview']=='0'){
                $bot_text = '📬  '.$product['amoName'];
                if($utm_source!=='0'){ $bot_text.=' / '.$utm_source; }
               
                $bot_text.=' / '.$form_email;
               
                if ($product['amoPrice'] == 0) 
                {
                    Slack::webfunnel($bot_text);
                }
                else
                {
                    Slack::report($bot_text);
                }

                //  $ref1    = time().'_'.rand();
                // $task1   = array(
                //  'text' => $bot_text
                //  );
                
                // $process_id = 294168;

                // $CZ->add_task($ref1, $process_id, $task1);

                // $corezoid_time = Pulse::timer(false);
                // $res = $CZ->send_tasks();
                // Pulse::log(Pulse::timer($corezoid_time), 'core', 'corezoid', 'slack', '0', '0');
            }

            // $api_login = '85208';
            // $api_secret = 'Wk83zM9Ah4fVsat8srvPUgEa2uO4uj6W5CxZ4xokfMa8JMgZ6m';

            // $CZ = new Corezoid($api_login, $api_secret);

            // $corezoid_form_phone = preg_replace('~\D+~','',$form_phone); 

            // $ref1    = time().'_'.rand();
            // $task1   = array(
            //  'email' => $data['email'], 
            //  'name' => $form_name, 
            //  'phone' => $corezoid_form_phone, 
            //  'list' => $product['grNew']
            //  );
            // $process_id = 294161;

            // $CZ->add_task($ref1, $process_id, $task1);

            // $corezoid_time = Pulse::timer(false);
            // $res = $CZ->send_tasks();
            // Pulse::log(Pulse::timer($corezoid_time), 'core', 'corezoid', 'activecampaign', '0', '0');

            Email::update($data['email'], $form_name, $form_phone, $product['grNew'] );
    	}

        // Если это уникальная регистрация – добавляем ее
        // if ($lead_uniq == '0') {

            // if (empty($_COOKIE['affilate'])) {

            //     $affilate_id = '0';

            // }else{

            //     $affilate_id = $_COOKIE['affilate'];
            // }

            if ($product['affilate_cost'] !== '0') 
            {
                if ($_COOKIE['affilate'] !== '0' && !empty($_COOKIE['affilate'])) 
                {
                    $affilate_id = $_COOKIE['affilate'];
                }
                else
                {
                    $affilate_id = '0';
                }
            }
            else
            {
                $affilate_id = '0';
            }

            MySQL::connect();
            $submit = MySQL::query(" INSERT INTO `app_leads`( `contact`, `amo`, `status`, `utmsourse`, `utmmedium`, `utmcampaing`, `utmterm`, `utmcontent`, `product`, `affilate`) VALUES ('$contact_id', '$lead_id', '$lead_status', '$utm_source', '$utm_medium', '$utm_campaign', '$utm_term', '$utm_content', '$product_id', '$affilate_id') ");
            $submit_id = mysql_insert_id();

            if ($product['affilate_reg'] !=='0' && $_COOKIE['affilate'] !== '0'  && !empty($_COOKIE['affilate'])) 
            {
                $affilate_id = $_COOKIE['affilate'];
                $affilate_reg = $product['affilate_reg'];

                MySQL::query(" INSERT INTO `app_affilate_payments`( `type`, `product`, `sub_id`, `amount`, `currency`, `affilate`) VALUES ('reg', '$product_id', '$submit_id', '$affilate_reg', 'USD', '$affilate_id') ");
            }
        // }

    	$response['status']='success';
    	$response['redirect'] = $product['redirect'].'?name='.$form_name.'&email='.$form_email.'&phone='.$form_phone.'&id='.$submit_id;
    	echo json_encode($response);

        $pulse['status'] = 'ok';

    // Если не нашли
    }else{
    	
        $pulse['status'] = 'notfound';
        $product_id = '0';
        $contact_id = '0';

        $referer = strtok($_SERVER['HTTP_REFERER'], '?');
        $bot_text = '🚨 Замечено, что кто-то пытался зарегестрироваться со страницы, которой я не знаю '.$referer;
        Slack::general($bot_text);
        Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));

    }

    $time = Pulse::timer($time);
    Pulse::log($time, 'core', 'submit_new', $pulse['status'], $product_id, $contact_id);

?>