<?

	// ПРОЧТИ ЭТО ОБЯЗАТЕЛЬНО
	// Это самый важный файл в системе. Редактируя его, перечитай код повторно, чтобы не было никаких ошибок
	// Внизу ты найдеш ключевые функции, изменяя который ты должен знать, что последствия будут сильними
	// Если есть желаение добавить новую функцию подумай сначала, как это сделать по-другому и только потом редактируй этот файл

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 0);

	class API {

		// Подключение к базе данных
		function connect(){
			$host = 'localhost';
			$user = 'kirgkybv_plzapp';
			$pswd = '#ZN+]kN+eR,N';
			$db = 'kirgkybv_polza_app';
			
			$connection = mysql_connect($host, $user, $pswd);
			mysql_query("SET NAMES utf8");
			if(!$connection || !mysql_select_db($db, $connection)){return false;}
			return $connection;
	    }

	    function pulse_timer($t){

			if ( empty($t) ) {
				return microtime(true);
			}else{

				$start = $t;
				$end = microtime(true);
				return number_format(($end - $start), 5);
			}
		}

		function pulse_log($t, $k1, $k2, $k3, $k4, $k5){

			$this->connect();

			$sql = " INSERT INTO `app_pulse` ";
		    $sql.= "( `time`, `key1`, `key2`, `key3`, `key4`, `key5`) ";
		    $sql.= " VALUES ";
		    $sql.= "('$t', '$k1', '$k2', '$k3', '$k4', '$k5')";

		    mysql_query($sql) or die(mysql_error());
			mysql_close();
		}

	    // Экспериментальная функция, для работы с API микро-сервисов
	    function get($s, $f, $q){

	    	if ($q !== false) {
	    		$sf = 'http://polza.com/app/api/'.$s.$q;
	    	}else{
	    		$sf = 'http://polza.com/app/api/'.$s;
	    	}

	    	if ($f == 'json') {
	    		return json_decode(file_get_contents($sf));
	    	}
	    	else{
	    		return file_get_contents($sf);
	    	}
	    }

	    // Запрос к базе данных
	    // Его можно использовать, как SELECT, если есть LIMIT 1
	    // или с UPDATE и INSERT
	    function query($q){
	    	$result = mysql_query($q);
			$row = mysql_fetch_array($result);
			return $row;
	    }

	    // Отправка СМС
	    // По сути здесь мы чистим данные и делаем запрос к микро-сервису
	    function send_sms($t, $n, $p){

	 		$sms_text = $n.$t;
    		$sms_text = urlencode($sms_text);
			$form_phone = preg_replace('~\D+~','',$p);  
    		$sms_url = 'https://smsc.ru/sys/send.php?login=polzacom&psw=Molotok2017!!&phones='.$form_phone.'&mes='.$sms_text.'&charset=utf-8&sender=polza';
    		file_get_contents($sms_url);
	    }

	    // Отправка добавление e-mail в ActiveCampaigh
	    // По сути здесь мы чистим данные и делаем запрос к микро-сервису
	    function add_email($e, $n, $p, $l){

	    	// $n = urlencode($n);
	    	// $p = preg_replace('~\D+~','',$p);  
      //       $email_url = 'http://polza.com/app/api/activecampaigh/control/update_contact.php?email='.$e.'&list='.$l.'&name='.$n.'&phone='.$p;
      //       file_get_contents($email_url);

			$email = $e;
			$list = $l;
			$name = $n;
			$phone = preg_replace('~\D+~','',$p); 

			// Формируем запрос
			$fields = array(
					'email'=>$email,
					'api_action'=>'contact_sync',
					'api_key'=>'816a499cb7dd31846433d832b26a9f08822e41989aa64edcd3c9d355aba0fd5c3218281c',
					'first_name'=>$name,
					'phone'=>$phone,
					'p['.$list.']'=>$list
				);
			
			// Отправляем запрос на обновление контактной информации
		    $ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,'https://polza.api-us1.com/admin/api.php');
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
		    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
		    $out=curl_exec($ch); 
		    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

            
	    }

	    // ФУНКЦИЯ НЕ ИСПОЛЬЗУЕТСЯ
	    // Добавлем лид в AmoCRM
	    // По сути здесь мы чистим данные и делаем запрос к микро-сервису
	    function add_lead($n, $e, $p, $l, $t, $b, $u){
	    	$l = urlencode($l);
	    	$n = urlencode($n);
	    	$t = urlencode($t);
	    	$u = urlencode($u);
	    	$p = preg_replace('~\D+~','',$p);

	 		$amo_url = 'http://polza.com/app/api/amocrm/control/add_lead.php?name='.$n.'&email='.$e.'&phone='.$p.'&lead='.$l.'&tags='.$t.'&budget='.$b.'&utm='.$u;
            $data = file_get_contents($amo_url);

		    $debug_url = 'http://polza.com/app/api/telegram/control/send_message.php?text=ClassAddLeadIs'.$data;
		    file_get_contents($debug_url);


            return $data;
	    }

	    function get_fin($s){

			$sql_request = " SELECT * FROM `app_payments_config` ";
			$sql_request.= " WHERE `system` = '".$s."' AND `status` = 'active' ";
			$sql_request.= " ORDER BY RAND () LIMIT 1 ";

			$result = mysql_query($sql_request);
			$row = mysql_fetch_array($result);
			return $row;
	    }

	}

?>