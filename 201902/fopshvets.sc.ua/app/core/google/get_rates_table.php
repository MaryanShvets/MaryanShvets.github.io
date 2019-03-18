<?

// polza.com/app/core/google/get_rates_table
// IMPORTRANGE("https://docs.google.com/spreadsheets/d/1dT6EkOPVa7RqUaEnQKyy-U1vOHUpPP_-fczQs_wygtI/edit";"d!A1:F1000")

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');

$time = Pulse::timer(false);

MySQL::connect();

$from = date("Y-m-d", strtotime('-60 days'));
$from = $from.' 00:00:01';

$list_courses = Memory::load('list_courses');

$data = mysql_query(" SELECT * FROM `app_pulse` WHERE `key2` = 'antitreningi_callback' AND `key3` LIKE '%rate_%' AND `datetime` >= '$from' ") or die(mysql_error());


$n = 0;
while ($row = mysql_fetch_array($data)) {
	$data_array[$n]['datetime'] = $row['datetime'];
	$data_array[$n]['key3'] = $row['key3'];
	$data_array[$n]['key4'] = $row['key4'];
	$data_array[$n]['key5'] = $row['key5'];
	$n++;
}

$uniq_data = array();
$uniq_table = array();


foreach ($data_array as $key => $value) {

	$student = $value['key4'];

	if (empty($student_emails[$student])) {

		$email_temp = MySQL::query( " SELECT `key5` FROM `app_pulse` WHERE `key2` = 'antitreningi_callback'  AND `key4` ='$student' LIMIT 1" );
		$student_emails[$student] = $email_temp['key5'];
		$student_email = $student_emails[$student];

	}else{

		$student_email = $student_emails[$student];
	}

	$course_info = explode("_", $value['key3']);
	$course_id = $course_info[1];
	$lesson_id = $course_info[2];
	$lesson_name = $lesson_id;


	$rate_info = explode("_", $value['key5']);
	$field = $rate_info[0];
	$rate = $rate_info[1];

	 switch($field) {
		case "789":
		case "666":
		case "667":
		case "668":
		case "680":
		case "675":
		case "728":
		case "677":
		case "679":
		case "681":
		case "676":
		case "950":
		case "671":
		case "731":
		case "672":
		case "729":
		case "673":
		case "951":
		case "674":

			if($_GET['test'] == 1){

				$rate = $rate + 1 - 1;

				if ($rate >= 10) {
					$rate = 10;
				}
			}
			else{

				$rate = $rate + 1 - 1;

				if ($rate >= 10) {
					$rate = 10;
				}
			}

			// if (empty($uniq_data[$lesson_name][$student_email])) 
			// {
			// 	$uniq_table[$lesson_name][$student_email] = $rate;
			// }
			// else{
				$uniq_table[$lesson_name][$student_email] = $rate;
			// }
           
   //         	echo '<tr>';
			// 	echo '<td>'.$value['datetime'].'</td>';
			// 	echo '<td>'.$student_email.'</td>';
			// 	echo '<td>'.'0'.'</td>';
			// 	echo '<td>'.$lesson_name.'</td>';
			// 	echo '<td>'.$field.'</td>';
			// 	echo '<td>'.$rate.'</td>';
			// echo '</tr>';

       break;
    }
}


// foreach ($uniq_table as $lessons) {
	
// 	foreach ($lessons as $student => $rate) {
// 			echo '<tr>';
// 				// echo '<td>'.$value['datetime'].'</td>';
// 				echo '<td>'.$student.'</td>';
// 				echo '<td>'.'0'.'</td>';
// 				echo '<td>'.$le.'</td>';
// 				echo '<td>'.$field.'</td>';
// 				echo '<td>'.$rate.'</td>';
// 			echo '</tr>';
// 	}
// }

echo '<table>';
foreach ($uniq_table as $key => $value) {
	foreach ($value as $student => $rate) {
		echo '<tr>';
			echo '<td>0</td>';
			echo '<td>'.$student.'</td>';
			echo '<td>'.'0'.'</td>';
			echo '<td>'.$key.'</td>';
			echo '<td>0</td>';
			echo '<td>'.$rate.'</td>';
		echo '</tr>';
	}
}

echo '</table>';

// echo '<pre>';
// print_r($good_array);
// echo '</pre>';

// echo json_encode($good_array);

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'google_get_rates_table', '0', '0', '0');

?>