<?

session_start();
session_write_close();

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

$row_array = array(
	array('name' => 'amoName'),
	array('name' => 'amoTags'),
	array('name' => 'amoPrice'),
	array('name' => 'price'),
	array('name' => 'amoview'),
	array('name' => 'grview'),
	array('name' => 'grNew'),
	array('name' => 'grEnd'),
	array('name' => 'URL'),
	array('name' => 'redirect'),
	array('name' => 'smsview'),
	array('name' => 'SmS'),
	array('name' => 'LMSview'),
	array('name' => 'LMScode'),
	array('name' => 'LMSkey'),
	array('name' => 'affilate_cost'),
	array('name' => 'affilate_reg'),
	array('name' => 'affilate_lp'),
	array('name' => 'redirectPay')
);

$sql = 'UPDATE `products` SET';

$c = 1;
$stop = count($row_array)-1;

foreach ($row_array as $key => $value) {

	$param = $value['name'];

	if($c<=$stop){
		$sql.= " `".$value['name']."` = '".$_POST[$param]."',";
	}
	else{
		$sql.= " `".$value['name']."` = '".$_POST[$param]."' ";
	}

	$c++;
}

$sql.=" WHERE `id` = '".$_POST['id']."' ";

MySQL::query($sql);

$time = Pulse::timer($time);
Pulse::log($time, 'edison', 'page_edit', '0', '0', $_POST['id']);

?>