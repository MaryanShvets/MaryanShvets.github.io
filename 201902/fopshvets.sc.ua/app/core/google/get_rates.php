<?

// polza.com/app/core/google/get_rates

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');

$time = Pulse::timer(false);

MySQL::connect();

$from = date("Y-m-d", strtotime('-60 days'));
$from = $from.' 00:00:01';

$list_courses = Memory::load('list_courses');

$data = mysql_query(" SELECT * FROM `app_pulse` WHERE `key2` = 'antitreningi_callback' AND `key3` LIKE '%rate_%' AND `datetime` >= '$from' ") or die(mysql_error());

// echo $from;

$n = 0;
while ($row = mysql_fetch_array($data)) {
	$data_array[$n]['datetime'] = $row['datetime'];
	$data_array[$n]['key3'] = $row['key3'];
	$data_array[$n]['key4'] = $row['key4'];
	$data_array[$n]['key5'] = $row['key5'];
	$n++;
}

// Pulse::log('0', 'core', 'antitreningi_callback', 'rate_'.$data['course'].'_'.$data['lesson'], $data['student_id'] , $field.'_'.$answer); 

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

	// if (!empty($list_courses[$course_id]['name'])) {
	// 	$course_name = $list_courses[$course_id]['name'];
	// }else{
	// 	$course_name = $course_id;
	// }

	// if (!empty($list_courses[$course_id]['lessons'][$lesson_id])) {
	// 	$lesson_name = $list_courses[$course_id]['lessons'][$lesson_id];
	// }else{
		$lesson_name = $lesson_id;
	// }


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
           $rate = $rate;
       break;

       default:
    			$rate = '0';
    		break;
    }


	$good_array[$key]['date'] = $value['datetime'];
	$good_array[$key]['email'] = $student_email;
	$good_array[$key]['course_name'] = '0';
	$good_array[$key]['lesson_name'] = $lesson_name;
	$good_array[$key]['field'] = $field;
	$good_array[$key]['rate'] = $rate;
	// echo $value['datetime'].' '.$rate.'<br>';
}

// echo '<pre>';
// print_r($good_array);
// echo '</pre>';

echo json_encode($good_array);

$time = Pulse::timer($time);
Pulse::log($time, 'core', 'google_get_rates', '0', '0', '0');

?>