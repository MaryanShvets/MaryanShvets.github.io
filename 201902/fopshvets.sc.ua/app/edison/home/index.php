<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link href="/app/edison/lib/ui.css?18072017" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/app/edison/lib/code.js"></script>
	
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" 
			integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" 
			crossorigin="anonymous"></script>

	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400,300,900&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>
<body>

	<!-- <div id="top-menu" onclick="menu_box()" > -->
	<div id="top-menu" onclick="aajax('home/start', 0)" >
		<div id="head-part">
			<a onclick="aajax('home/start', 0)" class="logo ajax">Edison</a>
			<!-- <a onclick="menu_box()" id="menu-btn">Menu</a> -->
			<!-- <div id="sub-menu">
				<a href="/app/edison/chat/dialogs" data-ajax="chat/dialogs"  data-program="chat" class="item ajax">Задачи</a>
				<a href="/app/edison/chat/settings" data-ajax="chat/settings"  data-program="chat" class="item ajax">Аналитика</a>
				<a href="/app/edison/control/page-list" data-ajax="control/page-list"  data-program="chat" class="item ajax">Управление</a>
				<a href="/app/edison/chat/settings" data-ajax="chat/settings"  data-program="chat" class="item ajax">База знаний</a>
			</div> -->
		</div>
	</div>

	<div id="menu-box" style="display: none;">
		<div class="container">
			<div class="grid-padded">
				<div class="grid">

					<!-- <div class="col">
						<p class="sub-header">Процессы</p>
						<ul>
							<li class="notactive">Мои задачи</li>
							<li class="notactive">Проекти</li>
						</ul>
					</div> -->
<!-- 
					<div class="col">
						<p class="sub-header">База знаний</p>
						<ul>
							<li onclick="aajax('database/article-list', 0)" >База знаний</li>
						</ul>
					</div> -->
					

					<div class="col">
						<p class="sub-header">Управление</p>
						<ul>
							<li onclick="aajax('database/article-list', 0)" >База знаний</li>
							<li onclick="aajax('control/page-list', 0)">Управление страницами</li>
							
							<!-- <li class="notactive">Пользователи</li> -->
							<!-- <li onclick="aajax('control/vk-foodhacking', 0)">ВК Фудхакинг</li> -->
							<!-- <li class="notactive">Счета</li> -->
							<ul>
								<!-- <li class="notactive">– Новый</li> -->
							</ul>
						</ul>
					</div>
					<div class="col">
						<p class="sub-header">Аналитика</p>
						<ul>
							<!-- <li onclick="aajax('metrics/dashboard', 0)">Дашборды</li> -->
								<!-- <ul>
									<li onclick="aajax('metrics/dashboard', 'fsd_3')">– ФСД-3</li>
									<li onclick="aajax('metrics/dashboard', 'code_deneg')">– Код Денег</li>
									<li onclick="aajax('metrics/dashboard', 'web_online')">– Вебинар 17</li>
								</ul> -->
							<li onclick="aajax('metrics/product-list', 0)">События в курсах</li>
							<li onclick="aajax('metrics/product-list', 0)">Ответы участников</li>
							<li onclick="aajax('metrics/system-list', 0)">Все события в Эдисоне</li>
							<li onclick="aajax('metrics/system-report', 0)">Состояние работы Эдисона</li>
						</ul>
					</div>
					<div class="col">
						<p class="sub-header">Финансы</p>
						<ul>
							<li onclick="aajax('finance/balance', 0)">Баланс на счетах</li>
							<li onclick="aajax('finance/payments', 0)">Список платежей</li>
							<li onclick="aajax('finance/invoice', 0)"> Выставить счет</li>
							<li onclick="aajax('finance/config', 0)">Список фин. систем</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="content">
		<?

			if($program=='home'){

				// include ($_SERVER['DOCUMENT_ROOT'].'/app/edison/home/start.php');

				echo '<script type="text/javascript">aajax(\'home/start\', 0);</script>';

			}elseif($program !=='home'){

				if (empty($_GET['param'])) {

					// include ($_SERVER['DOCUMENT_ROOT'].'/app/edison/'.$program.'/'.$page.'.php');
					echo '<script type="text/javascript">aajax(\''.$program.'/'.$page.'\', 0);</script>';
				}else{

					// include ($_SERVER['DOCUMENT_ROOT'].'/app/edison/'.$program.'/'.$page.'.php?param='.$_GET['param'] );
					echo '<script type="text/javascript">aajax(\''.$program.'/'.$page.'\', '.$_GET['param'].');</script>';
				}

				

			}

		?> 
	</div>

	<div id="loading">
		<div class="cssload-container">
			<ul class="cssload-flex-container">
				<li>
					<span class="cssload-loading"></span>
				</li>
			</div>
		</div>	
	</div>

	<div id="modal_info_box">
		<span id="text"></span>
	</div>

	<script type="text/javascript">

		$('document').ready(function() {

			<?

			if($program=='home'){
				echo 'aajax(\'home/start\', 0);';
			} else{
				if (empty($_GET['param'])) {

					// include ($_SERVER['DOCUMENT_ROOT'].'/app/edison/'.$program.'/'.$page.'.php');
					echo 'aajax(\''.$program.'/'.$page.'\', 0);';
				}else{

					// include ($_SERVER['DOCUMENT_ROOT'].'/app/edison/'.$program.'/'.$page.'.php?param='.$_GET['param'] );
					echo 'aajax(\''.$program.'/'.$page.'\', \''.$_GET['param'].'\');';
				}
			}
			
			?>

			loader('off');

			// $( ".top-menu" ).animate({
			// 	left: "0",
			// }, 500, function() {

				$( "#top-menu" ).animate({
					top: "0",
				}, 1000, function() {
					$( "#content" ).animate({
						opacity: "1",
					}, 1000, function() {
						
					});
				});

			// 	$( ".top-menu a" ).animate({
			// 		opacity: "1",
			// 	}, 500, function() {
			// 		$( "#content" ).animate({
			// 			opacity: "1",
			// 		}, 500, function() {
						
			// 		});
			// 	});
			// });

			
		});

		// $('a.ajax').click(function(){

		// 	var href = $(this).attr('data-ajax');

		// 	$('#content').css('opacity','0');

		// 	var new_url = 'http://polza.com/app/edison/'+href;
		// 	var send_url = '/app/edison/'+href+'.php';

		// 	$.ajax({
	 //           type: "GET",
	 //           url: send_url,
	 //           data:{}
		//          })
		// 			.done(function(data) {

		// 			window.history.pushState("object or string", "Title", new_url);

		//          	$('#content').html(data);

	 //           		$( "#content" ).animate({
		// 				opacity: "1",
		// 			}, 500, function() {
						
		// 			});

		// 	});

		// 	return false;
		// });

		



	</script>
	
</body>
</html>