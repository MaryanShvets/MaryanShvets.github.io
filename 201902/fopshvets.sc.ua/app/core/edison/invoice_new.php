<?

	// include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	// $api = new API();
	// $api->connect();

	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/access.php');

	$time = Pulse::timer(false);

	MySQL::connect();

	$currency = $_POST['currency'];
	$amount = $_POST['summ'];
	$email = $_POST['email'];
	$desc = $_POST['desc'];

	$fin_data = Access::finance('random','pay2me');

    if ($fin_data['status'] == 'active') 
    {
        $rub_system = 'pay2me';
    }
    else
    {
    	$rub_system = 'fondy';
    }

	if ($currency == 'RUB') 
	{
		$system = $rub_system;
	}
	else
	{
		$system = 'fondy';
	}

	// $pulse_url = 'https://neary.info/api/pulse/event_new?key1=polza&key2=invoice&key3='.$system.'&key4='.$currency.'&key5='.$amount;
	// file_get_contents($pulse_url);

	// $bot_text = 'выставлен счет на '.$amount.' '.$currency.' через '.$system;

	$date_create = date( 'Y-m-d');
	$date_create_sql = date("Y-m-d H:i:s", strtotime('+7 hours'));
	$date_exp = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+25, date("Y")));

	MySQL::query(" INSERT INTO `app_payments`( `order_id`, `date_create`, `pay_channel`, `type`, `email`, `pay_amount`, `pay_currency`, `order_desc` ) VALUES ('0', '$date_create_sql', '$system', 'invoice', '$email', '$amount', '$currency', '$desc' ) ");

	$submit_id = mysql_insert_id();

	$subject = 'Вам был выставлен счет №'.$submit_id;

	$headers = "From: Отдел Пользы <op@polza.com>\r\n";
	$headers .= "Reply-To: op@polza.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	$message .= '
<div style="    width: 100%;
    background: #eceff1;
    font-family: sans-serif;
    display: inline-block;">
	<div style="background-color:#ffffff;width:90%;max-width:600px;margin:auto;border-radius:3px;padding-bottom:30px;margin-top:35px;margin-bottom:35px"><h1 style="border-bottom:1px solid #01bfa5;font-size:24px;padding-bottom:20px;text-align:center;padding-top:15px;padding-left:15px;padding-right:15px;font-weight:normal">Вам был выставлен счет №'.$submit_id.'</h1>
    <div style="
    width: 70%;
    margin-left: auto;
    margin-right: auto;
">
			
			
			<p style="font-size: 18px;
    border-bottom: 1px solid rgba(211,212,213,0.99);
    font-weight: 600;
    text-align: right;
    padding-bottom: 15px;padding-top:15px;"><strong style="
    display: inline-block;
    float: left;
    font-weight: 400;

">Сумма к оплате: </strong> '.$amount.' '.$currency.'</p>
			<p style="font-size: 18px;
    border-bottom: 1px solid rgba(211,212,213,0.99);
    font-weight: 600;
    text-align: right;
    padding-bottom: 15px;"><strong style="
    display: inline-block;
    float: left;
    font-weight: 400;
">Назначение:</strong> '.$desc.'</p>
			<p style="font-size: 18px;
    border-bottom: 1px solid rgba(211,212,213,0.99);
    font-weight: 600;
    text-align: right;
    padding-bottom: 15px;"><strong style="
    display: inline-block;
    float: left;
    font-weight: 400;
">Дата выставления счета:</strong> '.$date_create.'</p>
			<p style="font-size: 18px;
   
    font-weight: 600;
    text-align: right;
    padding-bottom: 15px;"><strong style="
    display: inline-block;
    float: left;
    font-weight: 400;
">Срок действия счета:</strong> '.$date_exp.'</p>
			</div>
			<center><a href="http://polza.com/app/core/'.$system.'/invoice.php?id='.$submit_id.'" style="background:#01bfa5;font-weight:200;border-radius:3px;/* padding:10px 15px; */color:white;width:auto;text-align:center;margin-left:15px;margin-right:15px;/* padding-left:50px; *//* padding-right:50px; */font-size:22px;text-decoration:none;display:inline-block;width: 70%;margin-left: auto;margin-right: auto;padding-top: 10px;padding-bottom: 10px;">Оплатить</a></center></div>
				<div style="text-align:center; font-size:12px; padding-bottom:20px; padding-top:20px;" class="col-md-12 text-center fs-12 pb-20">
			        © polza.com Все права защищены. <a target="_blank" href="http://pages.polza.com/publichnyiy-dogovor">Публичный договор</a>.<br>
			        По всем вопросам: team@mail.polza.com
			      </div>
			</div>

	';

	mail($email, $subject, $message, $headers);

	$time = Pulse::timer($time);
	Pulse::log($time, 'edison', 'invoice_new', '0', '0', $submit_id);


?>