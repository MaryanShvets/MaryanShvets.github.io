<?

class SMS{

	public static function send($t, $n, $p)
	{

		$time = Pulse::timer(false);

		$sms_text = $n.$t;
		$sms_text = urlencode($sms_text);
		$form_phone = preg_replace('~\D+~','',$p);  
		$sms_url = 'https://smsc.ru/sys/send.php?login=polzacom&psw=Molotok2017!!&phones='.$form_phone.'&mes='.$sms_text.'&charset=utf-8&sender=polza';

		// http://smsc.ru/sys/send.php?login=polzacom&psw=Molotok2017!!&phones=380933843132&mes=привет&charset=utf-8&sender=polza

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,$sms_url);
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
		    curl_setopt($ch,CURLOPT_HEADER,false);
		    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    curl_close($ch);

	    $time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_sms', $code, '0', $form_phone);
	}

	public static function send_fast($t, $n, $p)
	{
			$time = Pulse::timer(false);

			$sms_text = $n.$t;
			$sms_text = urlencode($sms_text);
			$form_phone = preg_replace('~\D+~','',$p);  
			$sms_url = 'https://smsc.ru/sys/send.php?login=polzacom&psw=Molotok2017!!&phones='.$form_phone.'&mes='.$sms_text.'&charset=utf-8&sender=polza';

			$ch=curl_init();
			    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			    curl_setopt($ch,CURLOPT_URL,$sms_url);
			    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
			    curl_setopt($ch,CURLOPT_HEADER,false);
			    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
		    $out=curl_exec($ch); 
		    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

		    curl_close($ch);

		    echo $code.'<br>';

			return Pulse::timer($time);
	}
}

?>