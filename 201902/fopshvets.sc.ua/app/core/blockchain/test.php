<?

ini_set('display_errors', 1);

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/blockchain.php');

$data = array(
	'time'=>time(),
	'email'=>'vl@polza.com',
	'product'=>'313'
);

// Blockchain::record_new($data);

?>