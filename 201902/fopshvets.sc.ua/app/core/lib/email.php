<?

class Email{

	public static function update($email, $name, $phone, $list){
 
 		$time = Pulse::timer(false);

 		$phone = preg_replace('~\D+~','',$phone); 

		$fields = array(
				'email'=>$email,
				'api_action'=>'contact_sync',
				'api_key'=>'816a499cb7dd31846433d832b26a9f08822e41989aa64edcd3c9d355aba0fd5c3218281c',
				'first_name'=>$name,
				'phone'=>$phone,
				'p['.$list.']'=>$list
			);
		
	    $ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,'https://polza.api-us1.com/admin/api.php');
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
		    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    curl_close($ch);

	    $time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_email', $code, $list, $email);
	}

	public static function update_fast($email, $list){
 
 		$time = Pulse::timer(false);

 		$phone = preg_replace('~\D+~','',$phone); 

		$fields = array(
				'email'=>$email,
				'api_action'=>'contact_sync',
				'api_key'=>'816a499cb7dd31846433d832b26a9f08822e41989aa64edcd3c9d355aba0fd5c3218281c',
				'p['.$list.']'=>$list
			);
		
	    $ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,'https://polza.api-us1.com/admin/api.php');
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
		    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    curl_close($ch);

	    $time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_email', $code, $list, $email);
	}

	public static function info($email){

		$fields = array(
				'id'=>$email,
				'api_action'=>'contact_view',
				'api_key'=>'816a499cb7dd31846433d832b26a9f08822e41989aa64edcd3c9d355aba0fd5c3218281c',
				'api_output'=>'json'
			);

		$url = 'https://polza.api-us1.com/admin/api.php?'.http_build_query($fields);
		
	    $ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL, $url);
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST, 'GET');
		    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    return $out;

	    curl_close($ch);
	}

	public static function tag_add($tag, $email)
	{
		$time = Pulse::timer(false);

		$fields = array(
				'email'=>$email,
				'api_action'=>'contact_sync',
				'api_key'=>'816a499cb7dd31846433d832b26a9f08822e41989aa64edcd3c9d355aba0fd5c3218281c',
				'tags'=>$tag
			);
		
	    $ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,'https://polza.api-us1.com/admin/api.php');
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
		    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    curl_close($ch);

	    $time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_email', $code, 'tag_'.$tag, $email);
	}

	public static function field_add($field, $data, $email)
	{
		$time = Pulse::timer(false);

		$fields = array(
				'email'=>$email,
				'api_action'=>'contact_sync',
				'api_key'=>'816a499cb7dd31846433d832b26a9f08822e41989aa64edcd3c9d355aba0fd5c3218281c',
				'field[%'.$field.'%,0]'=>$data
			);
		
	    $ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,'https://polza.api-us1.com/admin/api.php');
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
		    curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
		    curl_setopt($ch,CURLOPT_HTTPHEADER,array('application/x-www-form-urlencoded; charset=utf-8'));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    curl_close($ch);

	    $time = Pulse::timer($time);
    	Pulse::log($time, 'core', 'lib_email', $code, 'field_'.$field, $email);
	}
} 

?>