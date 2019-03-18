<?

class Antitreningi{

	public static function add($name, $email, $integration, $secret){

		$time = Pulse::timer(false);

		$last_name = '';
		$phone = '';

		$hash = md5($email . ":" . $integration . ":" . $name . ":" . $last_name . ":" . $phone . ":" . $secret);

		$fields = array(
			'email'=>$email,
			'integration_id'=>$integration,
			'first_name'=>$name,
			'status'=>'active',
			'hash'=>$hash
		);

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,'http://antitreningi.ru/api/benefits/crm');
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
		    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    return $code;

		$time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_antitreningi', $code, 'active_'.$integration, $email);
	}

	public static function remove($name, $email, $integration, $secret)
	{

		$time = Pulse::timer(false);

		$name = '';

		$last_name = '';
		$phone = '';

		$hash = md5($email . ":" . $integration . ":" . $name . ":" . $last_name . ":" . $phone . ":" . $secret);

		$fields = array(
			'email'=>$email,
			'integration_id'=>$integration,
			'first_name'=>$name,
			'status'=>'block',
			'hash'=>$hash
		);

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,'http://antitreningi.ru/api/benefits/crm');
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
		    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    return $code;

		$time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_antitreningi', $code, 'block_'.$integration, $email);
	}

	public static function delete($name, $email, $integration, $secret)
	{

		$time = Pulse::timer(false);

		$name = '';

		$last_name = '';
		$phone = '';

		$hash = md5($email . ":" . $integration . ":" . $name . ":" . $last_name . ":" . $phone . ":" . $secret);

		$fields = array(
			'email'=>$email,
			'integration_id'=>$integration,
			'first_name'=>$name,
			'status'=>'delete',
			'hash'=>$hash
		);

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,'http://antitreningi.ru/api/benefits/crm');
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
		    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);


	    return $out;
	    // if ($out == 'OK') {
	    // 	return 200;
	    // }
	    // else
	    // {
	    // 	return 500;
	    // }

		$time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_antitreningi', $code, 'delete_'.$integration, $email);
	}
}

?>