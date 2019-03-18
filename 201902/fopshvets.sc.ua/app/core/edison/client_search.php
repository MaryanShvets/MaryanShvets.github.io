<?

session_start();
session_write_close();

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');

$time = Pulse::timer(false);

MySQL::connect();

// $name = '0';
// $phone = '0';
// $email = '0';

$email = $_POST['email'];

$mysql = " SELECT *  FROM `app_contact` WHERE `email` LIKE '%$email%' LIMIT 50 ";

$data = mysql_query($mysql) or die(mysql_error());

echo '<br>';

echo '<table  cellspacing="0">';

	while ($row = mysql_fetch_array($data)) {

	echo '
	<tr>
		<td onclick="aajax(\'control/client-edit\', \''.$row['id'].'\')"><a ><img src="/app/control/frontend/svg/basic_gear.svg"/></a></td>
		<td>'.$row['name'].'</td>
		<td>'.$row['phone'].'</td>
		<td>'.$row['email'].'</td>
		<td>'.$row['affilate'].'</td>
		<td>'.$row['chatfuel'].'</td>';
		
	echo '</tr>';

	}

echo '</table>';



$time = Pulse::timer($time);
Pulse::log($time, 'edison', 'client_search', 'ok', '0', '0');	

?>