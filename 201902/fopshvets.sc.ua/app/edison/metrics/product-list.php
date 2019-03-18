<div class="container">

	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<li>События</li>
		<li onclick="aajax('metrics/product-list', 0)" class="ajax" >Обновить</li>
	</ul>

	<?

	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');

	MySQL::connect();

	$list_courses = Memory::load('list_courses');

	$today = date("Y-m-d", strtotime('+6 hours'));
	$today = $today.' 00:00:01';

	?>

	<br>

	<h1>Сегодня</h1>
	
	<br>

	<?
		$today_data = mysql_query(" SELECT * FROM `app_pulse` WHERE `key2` IN ('events_lms_rate','antitreningi_callback')  AND `datetime` >= '$today' AND `key5` !='aleks.m.roschyn@gmail.com' ORDER BY `datetime` DESC  LIMIT 500 ") or die(mysql_error());
		
		echo '<div class="list">';
			while ($row = mysql_fetch_array($today_data)) {

				switch ($row['key2']) {
					
					case 'events_lms_rate':

							$pieces = explode("_", $row['key3']);
							$course_id = $pieces[0];
							$lesson_id = $pieces[1];

							$rate = explode("_", $row['key4']);
							$type = $rate[0];
							$stars = $rate[1];

							$student = $row['key5'];

							if (empty($student_emails[$student])) {

								$email_temp = MySQL::query( " SELECT `key5` FROM `app_pulse` WHERE `key2` = 'antitreningi_callback'  AND `key4` ='$student' LIMIT 1" );
								$student_emails[$student] = $email_temp['key5'];
								$student_email = $student_emails[$student];

							}else{

								$student_email = $student_emails[$student];
							}


							echo '<div class="list-item">';

								if ($stars == '1') {
									echo '1️⃣';
								}
								if ($stars == '2') {
									echo '2️⃣';
								}
								if ($stars == '3') {
									echo '3️⃣';
								}
								if ($stars == '4') {
									echo '4️⃣';
								}
								if ($stars == '5') {
									echo '5️⃣';
								}


								echo '<span class="date">'.$row['datetime'].' </span>';

								if (!empty($list_courses[$course_id]['name'])) {
									echo '<span class="course">'.$list_courses[$course_id]['name'].'</span>';
								}else{
									echo '<span class="course">'.$course_id.'</span>';
								}

								echo '<span class="student">'.$student_email.'</span>';

								echo ' <span class="action">поставил оценку уроку </span> ';

								if (!empty($list_courses[$course_id]['lessons'][$lesson_id])) {
									echo $list_courses[$course_id]['lessons'][$lesson_id];
								}else{
									echo $lesson_id;
								}

							echo '</div>';

						break;

					case 'antitreningi_callback':

							$pieces = explode("_", $row['key3']);

							$course_id = $pieces[1];
							$lesson_id = $pieces[2];
					
							
								

								if ($pieces[0] == 'open') {

									echo '<div class="list-item">';

									echo '👁 '.'<span class="date">'.$row['datetime'].' </span>';

									if (!empty($list_courses[$course_id]['name'])) {
										echo '<span class="course">'.$list_courses[$course_id]['name'].'</span>';
									}else{
										echo '<span class="course">'.$course_id.'</span>';
									}
									
									echo '<span class="student">'.$row['key5'].'</span>';

									echo ' <span class="action">открыл урок</span> ';

									if (!empty($list_courses[$course_id]['lessons'][$lesson_id])) {
										echo $list_courses[$course_id]['lessons'][$lesson_id];
									}else{
										echo $lesson_id;
									}

									echo '</div>';


								}elseif($pieces[0] == 'passed'){

									echo '<div class="list-item">';

									echo '✅ '.'<span class="date">'.$row['datetime'].' </span>';

									if (!empty($list_courses[$course_id]['name'])) {
										echo '<span class="course">'.$list_courses[$course_id]['name'].'</span>';
									}else{
										echo '<span class="course">'.$course_id.'</span>';
									}
									
									echo '<span class="student">'.$row['key5'].'</span>';

									echo ' <span class="action">прошел урок</span> ';

									if (!empty($list_courses[$course_id]['lessons'][$lesson_id])) {
										echo $list_courses[$course_id]['lessons'][$lesson_id];
									}else{
										echo $lesson_id;
									}

									echo '</div>';

								
								}elseif($pieces[0] == 'add'){

									echo '<div class="list-item">';

									echo '🚀 '.'<span class="date">'.$row['datetime'].' </span>';

									echo '<span class="student">'.$row['key5'].'</span>';
									echo ' <span class="action">добавлен на курс </span> ';

									if (!empty($list_courses[$course_id]['name'])) {
										echo '<span class="">'.$list_courses[$course_id]['name'].'</span>';
									}else{
										echo '<span class="">'.$course_id.'</span>';
									}

									echo '</div>';
								}
								else{
										// echo $pieces[0];
								}
							

						break;
				}
			}
		echo '</div>';

	?>

	<br>

	<h1>Раньше</h1>
	
	<br>

	<?
		$today_data = mysql_query(" SELECT * FROM `app_pulse` WHERE `key2` IN ('events_lms_rate','antitreningi_callback') AND `datetime` <= '$today' ORDER BY `datetime` DESC  LIMIT 500 ") or die(mysql_error());
		
		echo '<div class="list">';
			while ($row = mysql_fetch_array($today_data)) {

				switch ($row['key2']) {
					
					case 'events_lms_rate':

							$pieces = explode("_", $row['key3']);
							$course_id = $pieces[0];
							$lesson_id = $pieces[1];

							$rate = explode("_", $row['key4']);
							$type = $rate[0];
							$stars = $rate[1];

							$student = $row['key5'];

							if (empty($student_emails[$student])) {

								$email_temp = MySQL::query( " SELECT `key5` FROM `app_pulse` WHERE `key2` = 'antitreningi_callback'  AND `key4` ='$student' LIMIT 1" );
								$student_emails[$student] = $email_temp['key5'];
								$student_email = $student_emails[$student];

							}else{

								$student_email = $student_emails[$student];
							}


							echo '<div class="list-item">';

								if ($stars == '1') {
									echo '1️⃣';
								}
								if ($stars == '2') {
									echo '2️⃣';
								}
								if ($stars == '3') {
									echo '3️⃣';
								}
								if ($stars == '4') {
									echo '4️⃣';
								}
								if ($stars == '5') {
									echo '5️⃣';
								}


								echo '<span class="date">'.$row['datetime'].' </span>';

								if (!empty($list_courses[$course_id]['name'])) {
									echo '<span class="course">'.$list_courses[$course_id]['name'].'</span>';
								}else{
									echo '<span class="course">'.$course_id.'</span>';
								}

								echo '<span class="student">'.$student_email.'</span>';

								echo ' <span class="action">поставил оценку уроку </span> ';

								if (!empty($list_courses[$course_id]['lessons'][$lesson_id])) {
									echo $list_courses[$course_id]['lessons'][$lesson_id];
								}else{
									echo $lesson_id;
								}

							echo '</div>';

						break;

					case 'antitreningi_callback':

							$pieces = explode("_", $row['key3']);

							$course_id = $pieces[1];
							$lesson_id = $pieces[2];
					
							
								

								if ($pieces[0] == 'open') {

									echo '<div class="list-item">';

									echo '👁 '.'<span class="date">'.$row['datetime'].' </span>';

									if (!empty($list_courses[$course_id]['name'])) {
										echo '<span class="course">'.$list_courses[$course_id]['name'].'</span>';
									}else{
										echo '<span class="course">'.$course_id.'</span>';
									}
									
									echo '<span class="student">'.$row['key5'].'</span>';

									echo ' <span class="action">открыл урок</span> ';

									if (!empty($list_courses[$course_id]['lessons'][$lesson_id])) {
										echo $list_courses[$course_id]['lessons'][$lesson_id];
									}else{
										echo $lesson_id;
									}

									echo '</div>';


								}elseif($pieces[0] == 'passed'){

									echo '<div class="list-item">';

									echo '✅ '.'<span class="date">'.$row['datetime'].' </span>';

									if (!empty($list_courses[$course_id]['name'])) {
										echo '<span class="course">'.$list_courses[$course_id]['name'].'</span>';
									}else{
										echo '<span class="course">'.$course_id.'</span>';
									}
									
									echo '<span class="student">'.$row['key5'].'</span>';

									echo ' <span class="action">прошел урок</span> ';

									if (!empty($list_courses[$course_id]['lessons'][$lesson_id])) {
										echo $list_courses[$course_id]['lessons'][$lesson_id];
									}else{
										echo $lesson_id;
									}

									echo '</div>';

								
								}elseif($pieces[0] == 'add'){

									echo '<div class="list-item">';

									echo '🚀 '.'<span class="date">'.$row['datetime'].' </span>';

									echo '<span class="student">'.$row['key5'].'</span>';
									echo ' <span class="action">добавлен на курс </span> ';

									if (!empty($list_courses[$course_id]['name'])) {
										echo '<span class="">'.$list_courses[$course_id]['name'].'</span>';
									}else{
										echo '<span class="">'.$course_id.'</span>';
									}

									echo '</div>';
								}
								else{
										// echo $pieces[0];
								}
							

						break;
				}
			}
		echo '</div>';

	?>

</div>

<style type="text/css">

	.list{
		width: 100%;margin-bottom: 50px;box-shadow: 0px 0px 5px rgb(227, 227, 227);border-radius: 2px;background: rgb(255, 255, 255);
	}
	.list .list-item{
		padding: 10px 20px;border-bottom: 1px solid rgb(236, 236, 236);
		font-weight: 300;
	}

	.list .list-item span.date{
		font-size: 14px;
		margin-right: 10px;
		/*color:grey;*/
		margin-left: 10px;
		font-weight: 100;
	}

	.list .list-item span.course{
		font-size: 14px;
		/*color:grey;*/
		margin-right: 10px;
		font-weight: 100;
		/*margin-left: 20px;*/
	}

	.list .list-item span.student{
		/*font-size: 14px;*/
		/*margin-right: 20px;*/
		/*margin-left: 20px;*/
		/*font-weight: 100;*/
	}

	.list .list-item span.action{
		/*font-size: 14px;*/
		/*margin-right: 20px;*/
		/*margin-left: 20px;*/
		font-weight: 100;
		/*color: grey;*/
	}

	table{width: 100%;margin-bottom: 50px;box-shadow: 0px 0px 5px rgb(227, 227, 227);border-radius: 2px;background: rgb(255, 255, 255);}
	table td{padding: 20px;border-bottom: 1px solid rgb(236, 236, 236);}
	table tr:last-child td{border-bottom: none;}
	table tr:hover{/*cursor: pointer;*/}
	tr:hover >td{background: rgb(244, 244, 244);}
</style>