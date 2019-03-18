<?

class Slack{

	public static function general($text){

		$time = Pulse::timer(false);
		
		// $text_slack = str_replace (' ','%20', $text);
		$text_slack = urlencode($text);
		
		$token = 'xoxp-3571134136-155894242546-162821923761-0e482cad18ca5fc86532325509a784e5';
		$url = 'https://slack.com/api/chat.postMessage?token='.$token.'&channel=1general&text='.$text_slack;

		// $url = urlencode($url);

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL, $url);
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
		    // curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    // curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

		// file_get_contents($url);

		$time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_slack', 'general', '0', $code);
	}

	public static function personal($name, $text){

		$time = Pulse::timer(false);
		
		$n = '@'.$name;
		$text_slack = str_replace (' ','%20', $text);
		// $text_slack = str_replace (' ','', $text);

		$token = 'xoxp-3571134136-155894242546-162821923761-0e482cad18ca5fc86532325509a784e5';
		$url = 'https://slack.com/api/chat.postMessage?token='.$token.'&channel='.$n.'&text='.$text_slack;

		file_get_contents($url);

		$time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_slack', 'personal', $name, '0');
	}

	public static function report($text){

		$time = Pulse::timer(false);


		// $text_slack = str_replace (' ','%20', $text);
		$text_slack = urlencode($text);

		// $text_slack = str_replace ('+','', $text_slack);

		$token = 'xoxp-3571134136-155894242546-162821923761-0e482cad18ca5fc86532325509a784e5';
		$url = 'https://slack.com/api/chat.postMessage?token='.$token.'&channel=reports_all&text='.$text_slack;

		// $url = urlencode($url);

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL, $url);
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
		    // curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    // curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

		// file_get_contents($url);

		$time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_slack', 'report', '0', $code);
	}

	public static function webfunnel($text){

		$time = Pulse::timer(false);


		// $text_slack = str_replace (' ','%20', $text);
		$text_slack = urlencode($text);

		// $text_slack = str_replace ('+','', $text_slack);

		$token = 'xoxp-3571134136-155894242546-162821923761-0e482cad18ca5fc86532325509a784e5';
		$url = 'https://slack.com/api/chat.postMessage?token='.$token.'&channel=webfunnel_leads&text='.$text_slack;

		// $url = urlencode($url);

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL, $url);
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
		    // curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    // curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

		// file_get_contents($url);

		$time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_slack', 'webfunnel', '0', $code);
	}

	public static function finance($text){

		$time = Pulse::timer(false);

		// $text_slack = str_replace (' ','%20', $text);
		$text_slack = urlencode($text);

		$token = 'xoxp-3571134136-155894242546-162821923761-0e482cad18ca5fc86532325509a784e5';
		$url = 'https://slack.com/api/chat.postMessage?token='.$token.'&channel=reports_finance&text='.$text_slack;

		// $url = urlencode($url);

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL, $url);
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
		    // curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    // curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

		// file_get_contents($url);

		$time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_slack', 'finance', '0', $code);
	}
}

?>