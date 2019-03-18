<?

ini_set('display_errors', 0);

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');

$time = Pulse::timer(false);

$referer = $_SERVER['HTTP_REFERER'];

$re_course = '/course_id=(.*?)&/';
preg_match_all($re_course, $referer, $course, PREG_SET_ORDER, 0);

$re_lesson = '/lesson_id=(.*?)\z/';
preg_match_all($re_lesson, $referer, $lesson, PREG_SET_ORDER, 0);

$course_id = $course[0][1];
$lesson_id = $lesson[0][1];
$rate = $_GET['rate'];
$type = $_GET['type'];
$student = $_GET['student'];

$memory = Memory::load('list_finhacks');

$num = array_rand($memory, 1);
$finhack = $memory[$num];

$url = "https://api.giphy.com/v1/gifs/random?api_key=KP6ZPyEWAll7TmnKh97NfqhS2Jy6m7Tc&tag=thanks&rating=G";
$data = json_decode(file_get_contents($url), true);


// $time = Pulse::timer($time);
// Pulse::log($time, 'core', 'events_lms_rate', $course_id.'_'.$lesson_id, $type.'_'.$rate, $student);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Спасибо</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400,300,900&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	<style type="text/css">
		body{
			font-family: 'Roboto', sans-serif;
			margin: 0;
			padding: 0;
			font-weight: 100;
			font-size: 18px;
			background: rgb(248, 248, 248);
			text-align: center;
		}
		.block-1{
			margin-bottom: 15px;
			border-radius: 2px;
			width: 30%;
			margin-right: 15px;
			display: inline-block;
			box-sizing: border-box;
			margin-top: 5%;
			text-align: left;
			min-width: 450px;
			box-shadow: 0px 0px 5px rgb(227, 227, 227);
			background: white;
			padding: 20px;
			padding-top: 0px;
			transition: all 0.3s;
		}
		.block-1:hover{
			box-shadow: 0px 10px 25px rgb(227, 227, 227);
		}
		p{
			padding: 20px 0px;
			margin: 0px;
			font-weight: 100;
			font-size: 48px;
			padding-bottom: 0;
		}
		img{width: 100%;
box-shadow: 0px 0px 5px rgb(227, 227, 227);
transition: all 0.3s;
border-radius: 3px;
margin-top: 20px;}
	</style>
</head>
<body>
	<div class="block-1">
		<p>Спасибо за оценку</p>
		<img src="<?=$data['data']['fixed_height_downsampled_url'];?>">
		<p style="font-size: 20px;text-align: left;"><?=$finhack;?></p>
		
	</div>
</body>
</html>