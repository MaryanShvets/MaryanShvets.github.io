<div class="container">

	<?

	// $_COOKIE['filter_rates_student'] = 'levchenkovic@gmail.com';
	// $_COOKIE['filter_rates_course'] = 'Деньги';

	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');

	MySQL::connect();

	$list_courses = Memory::load('list_courses');
	$list_groups = Memory::load('list_groups');

	if (!empty($_COOKIE['filter_rates_student']) || !empty($_COOKIE['filter_rates_course'])) 
	{

		// include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');
		// $list_groups = Memory::load('list_groups');

		$sql_filter = " WHERE ";

		echo '<h2>Отчеты ';

		if (!empty($_COOKIE['filter_rates_student']) && empty($_COOKIE['filter_rates_course'])) 
		{
			echo 'студента '.$_COOKIE['filter_rates_student'];

			$student_email = $_COOKIE['filter_rates_student'];

			$sql_filter.= " `student` =  '$student_email' ";
		}

		if (!empty($_COOKIE['filter_rates_course']) && empty($_COOKIE['filter_rates_student'])) 
		{
			echo ' курса '.$_COOKIE['filter_rates_course'];

			$sql_course_ids = "";

			foreach ($list_groups[$_COOKIE['filter_rates_course']] as $key => $value) {
				$sql_course_ids.= "'".$value."',"; 
			}

			$sql_course_ids = substr_replace($sql_course_ids,'',-1);

			$sql_filter.= " `course` IN (".$sql_course_ids.") ";
		}

		if (!empty($_COOKIE['filter_rates_course']) && !empty($_COOKIE['filter_rates_student'])) {
			
			echo 'студента '.$_COOKIE['filter_rates_student'];

			$student_email = $_COOKIE['filter_rates_student'];

			$sql_filter.= " `student` =  '$student_email' ";
			echo ' курса '.$_COOKIE['filter_rates_course'];

			$sql_course_ids = "";

			foreach ($list_groups[$_COOKIE['filter_rates_course']] as $key => $value) {
				$sql_course_ids.= "".$value.","; 
			}

			$sql_course_ids = substr_replace($sql_course_ids,'',-1);
			$sql_filter.= " AND `course` IN (".$sql_course_ids.") ";
		}

		echo ' // <a onclick="aajax_filter_metricsrateslist_open();" style="color:#0f82f6;">Фильтр</a></h2><br><br>';
	}
	else
	{
		$sql_filter = "";

		echo '<h2>Все отчеты // <a onclick="aajax_filter_metricsrateslist_open();" style="color:#0f82f6;">Фильтр</a></h2><br><br>';
	}


		$page_count = 100;
		$page_curent = $_GET['param'];
		$page_curent = $page_curent + 0;

		if (empty($page_curent)) 
		{
			$page_curent = 1;
			$start_from = 0;
		}
		else
		{
			$start_from = $page_curent * $page_count - $page_count;
		}

		$data = mysql_query(" SELECT * FROM `app_rates` $sql_filter ORDER BY  `app_rates`.`datetime` DESC  LIMIT $start_from, $page_count ") or die(mysql_error());

		$last_answer = 'none';

		echo '<table cellspacing="0" >';

			while ($value = mysql_fetch_array($data)) {

				$course_id = $value['course'];
				$lesson_id = $value['lesson'];
				$student_email = $value['student'];

				$current_answer = $student_email.'_'.$lesson_id;

				if (!empty($list_courses[$value['course']]['name'])) {
					$value['course'] = $list_courses[$value['course']]['name'];
				}

				if (!empty($list_courses[$course_id]['lessons'][$value['lesson']])) {
					$value['lesson'] = $list_courses[$course_id]['lessons'][$value['lesson']];
				}

				if (strlen($value['text']) < 75) 
				{

					if(preg_match("/.FILESTORAGE_IMG_(.*?)/s",$value['text'])) 
					{ 
						// $rate_content = 'IMAGES';

						$re = '/\[FILESTORAGE_IMG_(.*?)_(.*?)\]/m';
						$str = $value['text'];

						preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

						// print_r($matches);

						$rate_content = '<a target="_blank" href="http://e.polza.com/panel/file/c'.$course_id.'/f'.$matches[0][1].'/'.$matches[0][2].'"><span class="image"><img src="http://e.polza.com/panel/file/c'.$course_id.'/f'.$matches[0][1].'/'.$matches[0][2].'"/></span></a>';

						// http://e.polza.com/panel/file/c12060/f616614/image.jpg

					}
					else
					{
						$rate_content = '<span class="text">'.$value['text'].'</span>';
					}
					
				}
				else
				{
					$rate_content = '<span class="text">'.$value['text'].'</span>';
				}

				$rate_header = '<a target="_blank" style="color: black;" href="http://e.polza.com/ru/panel/lessons/preview?lesson_id='.$lesson_id.'&course_id='.$course_id.'"> <span class="course">'.$value['course'].'</span> – <span class="lesson">'.$value['lesson'].'</span></a>';

				if ($current_answer == $last_answer) 
				{
					echo '<tr ondblclick="rate_change_state(\''.$value['id'].'\')" id="rate_'.$value['id'].'" class="rate status_'.$value['status'].' second_part">';
						echo '<td>'.$rate_content.'</td>';
					echo '</tr>';
				}
				else
				{
					echo '<tr ondblclick="rate_change_state(\''.$value['id'].'\')" id="rate_'.$value['id'].'" class="rate status_'.$value['status'].'">';
						echo '<td><span class="read_mark">•</span><span class="datetime">'.$value['datetime'].'</span> – <span class="student">'.$value['student'].'</span> <br> '.$rate_header.'<br><br>'.$rate_content.'</td>';
					echo '</tr>';
				}

				$last_answer = $student_email.'_'.$lesson_id;
			}
			
		echo '</table>';



		$pagination_count = MySQL::query(" SELECT COUNT(*) as `count` FROM `app_rates` $sql_filter ");
		$pagination_count = $pagination_count['count'];
		$pagination_pages = ceil($pagination_count / $page_count);

		if ($pagination_pages > 1) 
		{
			if ($page_curent >= 3) {
				echo '<span class="pagination" onclick="aajax(\'metrics/rates-list\', 1)">Первая – 1</span>';
				echo '<span class="pagination" onclick="aajax(\'metrics/rates-list\', '.($page_curent - 1).')">Назад – '. ($page_curent - 1) .'</span>';
			}
			elseif($page_curent == 2)
			{
				echo '<span class="pagination" onclick="aajax(\'metrics/rates-list\', 1)">Первая – 1</span>';
			}


			echo '<span class="pagination active">Текущая – '.$page_curent.'</span>';

			if ($page_curent <= ($pagination_pages - 1)) {

				echo '<span class="pagination" onclick="aajax(\'metrics/rates-list\', '.($page_curent + 1).')">Дальше – '. ($page_curent + 1) .'</span>';
			}

			if ($page_curent != $pagination_pages) {
				echo '<span class="pagination"  onclick="aajax(\'metrics/rates-list\', '.$pagination_pages.')"> Последняя – '.$pagination_pages.'</span>';
			}
		}

		?>


</div>

<br>
<br>
<br>

<div id="modal_system">
	<div id="modal_system_inside">
		<div id="modal_system_head">
			<span onclick="modal_system_close()">Закрыть</span>
		</div>
		<div id="modal_system_content">
			<div id="modal_loading"><div class="cssload-container"><ul class="cssload-flex-container"><li><span class="cssload-loading"></span></li></div></div></div>
		</div>
	</div>
</div>

<style type="text/css">


	table{
		width: 100%;margin-bottom: 50px;
		/*box-shadow: 0px 0px 5px rgb(227, 227, 227);border-radius: 2px;background: rgb(255, 255, 255);*/
	}
	table tr{
		box-shadow: 0px 0px 5px rgb(227, 227, 227);
border-radius: 2px;
background: white;
display: inline-block;
width: 100%;
margin-bottom: 20px;
	}
	table td{
		padding: 20px;
		vertical-align: top;
		/*border-top: 5px solid rgb(248, 248, 248);*/
		/*border-bottom: 5px solid rgb(248, 248, 248);*/}
	table tr:last-child td{border-bottom: none;}
	table tr:hover{/*cursor: pointer;*/}
	tr:hover >td{/*background: rgb(244, 244, 244);*/}
	tr:first-child >td{border-top: none;}

	tr.second_part{margin-top: -20px;border-top: #0f82f6 1px solid;}
	.datetime,
	.course,
	.lesson,
	.student
	{
		font-size: 16px;
display: inline-block;
font-weight: 400;
	}
	.course{}
	.lesson{}
	.student{}
	.text{
		font-size: 16px;
	}

.pagination{
	transition: all 0.5s;
	margin: 5px;
	box-shadow: 0px 0px 5px rgb(227, 227, 227);
	border: 1px solid white;
	padding: 10px 20px;
	margin-right: 10px;
	display: inline-block;
	box-sizing: border-box;
	text-align: left;
	background: white;
}
.action_paid:hover,
.action_aprove:hover,
.info:hover,
.pagination:hover{
	cursor: pointer;
	box-shadow: 0px 0px 10px rgb(158, 158, 158);

}
.action_paid.not,
.action_aprove.not{
	color:red;
}
.action_paid.yes,
.action_aprove.yes{
	color:green;
}
.action_paid.block{
	cursor: block;
	opacity: 0.3;
}
.action_paid.block:hover{
	box-shadow: 0px 0px 5px rgb(227, 227, 227);
	cursor: block;
}

.pagination{
	border-radius: 10px;
}
.pagination.active{
	color: #0f82f6;
	font-weight: 400;
}
.pagination.active:hover{
	cursor: initial;;
}
tr.status_0 td{}
tr.status_1 td{}
tr.status_0 {
	/*background: rgba(15, 130, 246, 0.25);*/
}
tr.status_1 {
	opacity: 0.5;
	transition: all 0.3s ease;
}
tr.status_1:hover {
	/*opacity: 1;*/
}
tr.status_0 .read_mark{
	color: #0f82f6;
font-weight: bold;
margin-right: -9px;
position: relative;
left: -14px;
top:3px;
font-size: 24px;
line-height: 0px;
}
tr.status_1 .read_mark{
	display: none;
	margin-right: 0px;
}

tr.status_active .read_mark{
	color: #ffba05;
}

span.image{}
span.image img{
	width: 250px;
}

</style>
