<?

class Vk_API {

	function auth($id, $client_secret){

		$ch=curl_init();

		$url = 'https://oauth.vk.com/access_token?client_id='.$id.'&client_secret='.$client_secret.'&grant_type=client_credentials';

	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	    curl_setopt($ch,CURLOPT_URL,$url);
	    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
	    curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
	    curl_setopt($ch,CURLOPT_HEADER,false);
	  	
	  	$out = curl_exec($ch); 

	  	return $out;
	}

	function request($method, $parameters, $token, $version){

		$ch=curl_init();

		if ($parameters !== 0) {

			$get_params = http_build_query($parameters);
			$url = 'https://api.vk.com/method/'.$method.'?'.$get_params.'&access_token='.$token.'&v='.$version;

		}

	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	    curl_setopt($ch,CURLOPT_URL,$url);
	    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
	    curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
	    curl_setopt($ch,CURLOPT_HEADER,false);
	  	
	  	$out = curl_exec($ch); 

	  	return json_decode($out, JSON_OBJECT_AS_ARRAY);
	}
}

// Переггляд оголошення
// https://vk.com/dev/ads.getAdsLayout 

// Редагування оголошення
// https://vk.com/dev/ads.updateAds

?>