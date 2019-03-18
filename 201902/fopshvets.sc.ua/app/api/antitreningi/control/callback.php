<?

 	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
    $api = new API();

    $time = $api->pulse_timer(false);

    switch ($_GET['type']) {
    	
    	case 'add':

    			$data['course'] = $_POST['course']['id'];
			    $data['student'] = $_POST['lesson']['email'];

		    	$time = $api->pulse_timer($time);

		    	$api->pulse_log($time, 'api', 'antitreningi', 'callback', 'add_'.$data['course'], $data['student']);

    		break;
    	
    	case 'passed':

    			$data['course'] = $_POST['course']['id'];
			    $data['student'] = $_POST['lesson']['email'];

			    // $data['statistic'] = $_POST['homework']['answers'];

			    // foreach ($data['statistic'] as $key => $value) 
			    // {

			    // 	if ($value['type'] == 'statistic') 
			    // 	{
			    		
			    // 		foreach ($value['options'] as $option_key => $option_value) 
			    // 		{
			    // 			$field = $option_value['field'];
			    // 			$answer = $option_value['answer'];

			    			
			    // 		}
			    // 	}
			    // }

		    	$time = $api->pulse_timer($time);
		
		    	$api->pulse_log($time, 'api', 'antitreningi', 'callback', 'passed_'.$data['course'], $data['student']);

    		break;
    }



 //    $data['course'] = $_POST['course']['id'];
 //    $data['lesson'] = $_POST['lesson']['id'];
 //    $data['student'] = $_POST['lesson']['email'];

	// $time = $api->pulse_timer($time);
	// $api->pulse_log($time, 'api', 'antitreningi', 'callback', 'alpha', 'course_'.$data['course']);
	// $api->pulse_log($time, 'api', 'antitreningi', 'callback', 'alpha', 'lesson_'.$data['lesson']);
	// $api->pulse_log($time, 'api', 'antitreningi', 'callback', 'alpha', 'student_'.$data['student']);


	// $course = $event->getCourse();
	// $data = [
	// 	'course' => [
	// 		'id' => $course->id,
	// 		'title' => $course->title,
	// 	],
	// ];

	// if ($event instanceof LessonCapableEventInterface) {
	// 	$lesson = $event->getLesson();
	// 	$data['lesson'] = [
	// 		'id' => $lesson->id,
	// 		'title' => $lesson->title,
	// 	];
	// }

	// if ($event instanceof StudentCapableEventInterface) {
	// 	$student = $event->getStudent();
	// 	$data['lesson'] = [
	// 		'id' => $student->id,
	// 		'name' => $student->name,
	// 		'surname' => $student->surname,
	// 		'email' => $student->login,
	// 		'tags' => array_map(function ($tag) {
	// 			return $tag->getTag();
	// 		}, $student->getTags((int)$course->author_id)),
	// 	];
	// }

// $curl = curl_init();

// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl, CURLOPT_POST, true);
// curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
// curl_exec($curl);
// curl_close($curl);
?>