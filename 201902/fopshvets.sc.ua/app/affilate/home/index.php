<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link href="/app/affilate/lib/ui.css?18072017" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/app/affilate/lib/code.js"></script>
	
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
			<a onclick="aajax('home/start', 0)" class="logo ajax">POLZA // AFFILATE</a>
			
		</div>
	</div>

	
	<div id="content">
		<?

			if($program=='home'){


				echo '<script type="text/javascript">aajax(\'home/start\', 0);</script>';

			}elseif($program !=='home'){

				if (empty($_GET['param'])) {

					echo '<script type="text/javascript">aajax(\''.$program.'/'.$page.'\', 0);</script>';
				}else{

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