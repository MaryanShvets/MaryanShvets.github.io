<?

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 1);

	// Получаем переменные 
	// $email = $_GET['email'];
	// $list = $_GET['list'];
	// $name = $_GET['name'];
	// $phone = $_GET['phone'];

	// Формируем запрос
	$fields = array(
			'api_action'=>'campaign_report_totals',
			'api_key'=>'816a499cb7dd31846433d832b26a9f08822e41989aa64edcd3c9d355aba0fd5c3218281c',
			'campaignid'=>'280'
		);

	$url = 'https://polza.api-us1.com/admin/api.php?api_action=campaign_report_totals';
	$url.= '?api_key='.$fields['api_key'].'&campaignid='.$fields['campaignid'].'&api_output=json';

	// echo $url.'<br>';
	// Отправляем запрос на обновление контактной информации
    $ch=curl_init();
    // curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
    // curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
    curl_setopt($ch,CURLOPT_HEADER,false);
    $out=curl_exec($ch); 
    // $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

    echo $out;

?>