<?

class IVR{
	
	public static function send($t, $p){

		$time = Pulse::timer(false);

		$ivr_file = urlencode($t);

		$ivr_phone = preg_replace('~\D+~','',$p);  
		$sms_url = 'https://smsc.ru/sys/send.php?login=polzacom&psw=Molotok2017!!&phones='.$ivr_phone.'&mes='.$ivr_file.'&call=1&sender=polza&param=10,3600,2';

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,$sms_url);
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    $time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_ivr', $code, '0', $ivr_phone);
	}
}

?>