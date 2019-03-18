<?

if ( empty($_COOKIE['user']) ) {

	$program = 'user';

	// if(empty($_GET['page']) || $_GET['page'] == 'signin'){
		$page = 'signin';
	// }else{
	// 	$page = 'signup';
	// } 

	include( $_SERVER['DOCUMENT_ROOT'].'/app/edison/home/index.php');

}elseif ( !empty($_COOKIE['user']) ) {

	

	$user = $_COOKIE['user'];

	if(empty($_GET['program'])){
		$program = 'home';
	}else{
		$program = $_GET['program'];
	}

	if(empty($_GET['page'])){
		$page = 'start';
	}else{
		$page = $_GET['page'];
	}

	if(empty($_GET['param'])){
		$param = '0';
	}else{
		$param = $_GET['param'];
	}

	include( $_SERVER['DOCUMENT_ROOT'].'/app/edison/home/index.php');
}

?>
		