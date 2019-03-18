<?

class Telegram{
	
	public static function api($token, $method, $data){

		$time = Pulse::timer(false);

		$url = 'https://api.telegram.org/bot'. $token .'/'. $method.'?'. http_build_query($data);

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,$url);
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    $time = Pulse::timer($time);

	    return $out;

	    // echo $url.'<br>';
	    // echo $out.'<br>';
	    // echo 'Code: '.$code;
    	Pulse::log($time, 'core', 'lib_telegram', $code, '0', '0');
	}
}

?>