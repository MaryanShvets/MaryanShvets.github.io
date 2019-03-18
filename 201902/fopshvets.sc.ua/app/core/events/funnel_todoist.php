<?

ini_set('display_errors', 1);

// Подключаем основной клас
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/todoist.php');

$time = Pulse::timer(false);

$todo = $_GET['todo'];
$project = $_GET['project'];

if (!empty($todo) && !empty($project)) 
{
	echo Todoist::add($todo, '5b5905c17b8cdb55951e8ddb452c451c147736b7', $project);
}

// echo Todoist::add('Удалить ученика '.$email.' с курса !!1 today', '5b5905c17b8cdb55951e8ddb452c451c147736b7', '$_kurs_delete');



$time = Pulse::timer($time);
Pulse::log($time, 'core', 'events_funnel_todoist', '0', '0', '0');

// http://polza.com/app/core/events/funnel_todoist?&todo=[text]&project=[project]

?>