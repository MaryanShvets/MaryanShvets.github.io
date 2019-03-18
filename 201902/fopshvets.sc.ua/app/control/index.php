<?

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 1);


if (empty($_COOKIE['user'])) {
	include( $_SERVER['DOCUMENT_ROOT'].'/app/control/views/login.php');
}elseif (!empty($_COOKIE['user'])) {

  	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	$api = new API();
	$api->connect();

  	$user = $_COOKIE['user'];
	$user_info = $api->query(" SELECT *  FROM `app_users` WHERE `id` = '$user' LIMIT 1 ");

	$access = $user_info['access'];

	if($access=='admin'){

		if(!empty($_GET['view'])){
			$view = $_GET['view'];
		}else{
			$view = 'dashboard';
		}

		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/views/'.$view.'.php');

	}elseif($access!=='admin'){

		$access_list = array(
			'sales'=>array(
					'invoice-list',
					'invoice-new',
					'payments-list'
				),
			'head-sales'=>array(
					'invoice-list',
					'invoice-new',
					'payments-list',
					'user-search'
				),
			'CFO'=>array(
					'finance'
				),
			'marketing'=>array(
					'submits',
					'product-list',
					'user-search'
				),
			'youtube'=>array(
					'youtube'
				),
			'test'=>array(
					'submits'
				)
		);

		if(!empty($_GET['view'])){

			$view = $_GET['view'];
			$ac = 0;
			foreach ($access_list[$access] as $key => $value) {
				if ($value == $view) {
					$ac = 1;
				}
			}

			if($ac == 0){
				include( $_SERVER['DOCUMENT_ROOT'].'/app/control/views/noaccess.php');
			}else{
				include( $_SERVER['DOCUMENT_ROOT'].'/app/control/views/'.$view.'.php');
			}

			$ac = 0;

		}else{
			$view = $access_list[$access][0];
			include( $_SERVER['DOCUMENT_ROOT'].'/app/control/views/'.$view.'.php');
		}

	}else{
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/views/noaccess.php');
	}
}

?>