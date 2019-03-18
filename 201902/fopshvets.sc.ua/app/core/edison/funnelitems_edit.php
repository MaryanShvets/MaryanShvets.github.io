<?

session_start();
session_write_close();

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

$row_array = array(

	array('name' => 'id'),
	array('name' => 'text')
);

$sql = 'UPDATE `app_funnel_items` SET';

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

$sql.=" WHERE `token` = '".$_POST['token']."' ";

// echo $sql;

MySQL::query($sql);

$time = Pulse::timer($time);
Pulse::log($time, 'edison', 'funnelitems_edit', '0', '0', $_POST['token']);

?>