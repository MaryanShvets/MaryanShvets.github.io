<?

if ( empty($_COOKIE['affilate_user']) ) {

	$program = 'user';
	$page = 'signin';

	include( $_SERVER['DOCUMENT_ROOT'].'/app/affilate/home/index.php');

}elseif ( !empty($_COOKIE['affilate_user']) ) {

	$affilate_user = $_COOKIE['affilate_user'];

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

	include( $_SERVER['DOCUMENT_ROOT'].'/app/affilate/home/index.php');
}

?>
		