<?

	$url = 'http://polza.com/app/control/?view=invoice-list';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	if($_GET['type']=='login'){
		$username = 'viktor.levchenko.av@gmail.com';
		$password = '4302539';
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'email='.$username.'&pass='.$password);
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	}
	elseif ($_GET['type']=='view') {
		curl_setopt ($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	}

	$content = curl_exec($ch);
	echo $content;
	curl_close($ch);
?>