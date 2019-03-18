<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/slack.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/email.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/sms.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/telegram.php');

$time = Pulse::timer(false);

switch ($_GET['type']) {
	
	case 'add':

			$data['course'] = $_POST['course']['id'];
		    $data['student'] = $_POST['student']['email'];
		    $data['student_id'] = $_POST['student']['id'];

		    if ($data['course'] == '12610')
		    {
		    	Slack::personal('oleksandr.roshchyn', 'В Финальный модуль на АТ добавлен '.$data['student']);
		    }

	    	$time = Pulse::timer($time);
	    	Pulse::log($time, 'core', 'antitreningi_callback', 'add_'.$data['course'], $data['student_id'], $data['student']);

		break;
	
	case 'open':

			$data['course'] = $_POST['course']['id'];
		    $data['student'] = $_POST['student']['email'];
		    $data['lesson'] = $_POST['lesson']['id'];
		    $data['student_id'] = $_POST['student']['id'];

	    	$time = Pulse::timer($time);
	    	Pulse::log($time, 'core', 'antitreningi_callback', 'open_'.$data['course'].'_'.$data['lesson'], $data['student_id'] , $data['student']);

		break;
	
	case 'passed':

			$data['course'] = $_POST['course']['id'];
		    $data['student'] = $_POST['student']['email'];
		    $data['student_id'] = $_POST['student']['id'];
		    $data['lesson'] = $_POST['lesson']['id'];


		    $insert_course = $_POST['course']['id'];
		    $insert_student = $_POST['student']['email'];
		    $insert_lesson = $_POST['lesson']['id'];


		    $data['statistic'] = $_POST['homework']['answers'];

		    foreach ($data['statistic'] as $key => $value) 
		    {

		    	if ($value['type'] == 'statistic') 
		    	{
		    		
		    		foreach ($value['options'] as $option_key => $option_value) 
		    		{
		    			$field = $option_value['field'];
		    			$answer = $option_value['answer'];

		    			// $bot_text = 'Ответ на вопрос '.$field.' '.$answer;
						// Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));		

						Pulse::log('0', 'core', 'antitreningi_callback', 'rate_'.$data['course'].'_'.$data['lesson'], $data['student_id'] , $field.'_'.$answer);    			
		    		}
		    	}

		  		elseif($value['type'] == 'text')
		  		{

		  			

		  			// foreach ($value['options'] as $option_key => $option_value) 
		    		// {
		    			$insert_answer = $value['options']['answer'];
		    			MySQL::connect();

		    			// Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>'Пінг-шпінг' ));
		    			// Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>'Відповідь '.$insert_answer ));

		    			MySQL::query( " INSERT INTO `app_rates`( `course`, `lesson`, `student`, `text`) VALUES ( '$insert_course','$insert_lesson','$insert_student', '$insert_answer' ) " );

		    			// $bot_text = 'Ответ на вопрос '.$field.' '.$answer;
						// Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));		
						// Pulse::log('0', 'core', 'antitreningi_callback', 'rate_'.$data['course'].'_'.$data['lesson'], $data['student_id'] , $field.'_'.$answer);    			
		    		// }
		  		}
		    }


		    // if (empty($_POST['homework'])) 
		    // {
		    // 	$rand_num = rand ( 1, 5 );

		    // 	if ($rand_num == 1) 
		    // 	{
		    // 		$bot_text = 'Статистики еще нет, но на всякий случай покажу '.json_encode($_POST, JSON_UNESCAPED_UNICODE);
		    // 	}
		    // 	else
		    // 	{
		    // 		$bot_text = 'Статистики еще нет 😐';
		    // 	}
		    // }
		    // else
		    // {
		    // $bot_text = 'Статистика для Вити ';
		    // }
		   
		    // Telegram::api('569665711:AAF3T0BQIwyckEnrG5gd2BYcb0bBTlubOKE', 'sendMessage', array( 'chat_id'=>'-300215944','text'=>$bot_text ));

	    	$time = Pulse::timer($time);
	    	Pulse::log($time, 'core', 'antitreningi_callback', 'passed_'.$data['course'].'_'.$data['lesson'], $data['student_id'] , $data['student']);

		break;
	
	case 'email_list':

		    $data['student'] = $_POST['student']['email'];

			Email::update_fast($data['student'], $_GET['list']);

	    	$time = Pulse::timer($time);
	    	Pulse::log($time, 'core', 'antitreningi_callback', 'email_list', $_GET['list'] , $data['student']);

		break;
	
	case 'email_tag':

		    $data['student'] = $_POST['student']['email'];
		    Email::tag_add($_GET['tag'], $data['student']);

	    	$time = Pulse::timer($time);
	    	Pulse::log($time, 'core', 'antitreningi_callback', 'email_tag', $_GET['tag'] , $data['student']);

		break;
	
	case 'email_field':

			$data['student'] = $_POST['student']['email'];

		    Email::field_add($_GET['field'], $_GET['input'], $data['student']);

	    	$time = Pulse::timer($time);
	    	Pulse::log($time, 'core', 'antitreningi_callback', 'email_field', $_GET['field'] , $data['student']);

		break;
	
	case 'sms_send':

		    $email = $_POST['student']['email'];
		    $sms = $_GET['item'];

		    MySQL::connect();

		    $contact = MySQL::query( "SELECT * FROM `app_contact` WHERE `email` = '$email' LIMIT 1 ");
			$phone = $contact['phone'];

			if ($phone !== 0 || $phone !=='0' || !empty($phone) ) 
			{
				$text = MySQL::query( "SELECT * FROM `app_funnel_items` WHERE `id` = '$sms' LIMIT 1 ");
				$text = $text['text'];

				SMS::send($text, '', $phone);
			}
			else
			{

				$phone = 'no_phone';
			}

	    	$time = Pulse::timer($time);
	    	Pulse::log($time, 'core', 'antitreningi_callback', 'sms_send', $_GET['item'] , $phone);

		break;
	
	case 'ivr_send':

		    $email = $_POST['student']['email'];
		    $sms = $_GET['item'];

		    MySQL::connect();

		    $contact = MySQL::query( "SELECT * FROM `app_contact` WHERE `email` = '$email' LIMIT 1 ");
			$phone = $contact['phone'];

			if ($phone !== 0 || $phone !=='0' || !empty($phone) ) {

				$file_audio = MySQL::query( "SELECT * FROM `app_funnel_items` WHERE `id` = '$sms' LIMIT 1 ");
				$file_audio = $file_audio['text'];

				IVR::send($file_audio, $phone);
			}
			else{

				$phone = 'no_phone';
			}

	    	$time = Pulse::timer($time);
	    	Pulse::log($time, 'core', 'antitreningi_callback', 'ivr_send', $_GET['item'] , $phone);

		break;

	default:
			echo $_GET['type'].' not found';
		break;

}

// http://polza.com/app/core/antitreningi/callback?type=add
// http://polza.com/app/core/antitreningi/callback?type=open
// http://polza.com/app/core/antitreningi/callback?type=passed
// http://polza.com/app/core/antitreningi/callback?type=email_list&list=200
// http://polza.com/app/core/antitreningi/callback?type=send_sms&item=200
// http://polza.com/app/core/antitreningi/callback?type=ivr_send&item=200

// http://polza.com/app/core/antitreningi/callback?type=email_tag&tag={tag_name}
// http://polza.com/app/core/antitreningi/callback?type=email_field&field={field_name}&input={field_input}

?>