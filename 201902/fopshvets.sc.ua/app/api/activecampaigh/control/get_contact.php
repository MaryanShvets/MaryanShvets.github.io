<?

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 1);

	// // Получаем переменные 
	// $email = 'kir.gorshkov@gmail.com';

	// // Формируем запрос
	// $fields = array(
	// 		'q'=>$email,
	// 		'type'=>'user'
	// 	);
	
	// // Отправляем запрос на обновление контактной информации
 //    $ch=curl_init();
 //    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
 //    curl_setopt($ch,CURLOPT_URL,'https://graph.facebook.com');
 //    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
 //    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
 //    curl_setopt($ch,CURLOPT_HEADER,false);
 //    $out=curl_exec($ch); 
 //    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

 //    echo $out;

    // $site = 'https://graph.facebook.com/v2.2/';
    // $site.= '?q='.$email.'&type=user';
    // $site.= 'me';

    // echo $site.'<br>';

    // $curl=curl_init();
    // curl_setopt($curl, CURLOPT_URL, $site);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    // $out = curl_exec($curl);
    // echo $out;
    // curl_close($curl);


?>