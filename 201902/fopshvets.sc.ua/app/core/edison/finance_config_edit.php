<?

session_start();
session_write_close();

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

$row_array = array(

	array('name' => 'system'),
	array('name' => 'status'),
	array('name' => 'description'),
	array('name' => 'key1'),
	array('name' => 'key2'),
	array('name' => 'key3')
);

$sql = 'UPDATE `app_payments_config` SET';

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

// echo $sql;

MySQL::query($sql);

$time = Pulse::timer($time);
Pulse::log($time, 'edison', 'finance_config_edit', '0', '0', $_POST['id']);

?>