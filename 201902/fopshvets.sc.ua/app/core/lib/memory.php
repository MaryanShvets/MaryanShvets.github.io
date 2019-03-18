<?

class Memory{

	public static function save($name, $data){

		$time = Pulse::timer(false);
		
		$data_url = $_SERVER['DOCUMENT_ROOT'].'/app/core/memory/'.$name.'.json';
		file_put_contents($data_url, json_encode($data));

		Pulse::log(Pulse::timer($time), 'core', 'lib_save', '0', '0', $name);
	}

	public static function load($name){

		$time = Pulse::timer(false);

		$url = 'http://polza.com/app/core/memory/'.$name.'.json';

		$ch = curl_init();
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
	    curl_setopt($ch,CURLOPT_URL, $url );
	    curl_setopt($ch,CURLOPT_CUSTOMREQUEST, 'GET' );
	    curl_setopt($ch,CURLOPT_HEADER, false );
	    $out = curl_exec($ch); 
	    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    
	    curl_close($ch);

	    if ($code == 200) {
	    	return json_decode($out, JSON_OBJECT_AS_ARRAY);
	    }else{
	    	return false;
	    }

	    Pulse::log(Pulse::timer($time), 'core', 'lib_load', $code, '0', $name);
	}
}

?>