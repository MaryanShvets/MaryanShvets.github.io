<!-- <div class="container dashboard"> -->

	<?
		if (empty($_GET['param'])) {

			?>

				<div class="container dashboard">
				<ul class="breadlike-nav">
					<li onclick="aajax('home/start', 0)" class="ajax" >Edison</li>
					<li>Дашборды</li>
				</ul>
				
			<?

			echo '<a onclick="aajax(\'metrics/dashboard\', \'tech\')" class="item ajax btn">Технический</a>';
			echo '<a onclick="aajax(\'metrics/dashboard\', \'fsd\')" class="item ajax btn">FSD-1</a>';
			echo '<a onclick="aajax(\'metrics/dashboard\', \'fsd_2\')" class="item ajax btn">FSD-2</a>';
			echo '<a onclick="aajax(\'metrics/dashboard\', \'fsd_3\')" class="item ajax btn">FSD-3</a>';
			echo '<a onclick="aajax(\'metrics/dashboard\', \'code_deneg\')" class="item ajax btn">Код Денег</a>';
			echo '<a onclick="aajax(\'metrics/dashboard\', \'web_online\')" class="item ajax btn">Вебинар 17</a>';

			echo '</div>';
		}else{

			?>
				<div class="container dashboard">
				<ul class="breadlike-nav">
					<li onclick="aajax('home/start', 0)" class="ajax" >Edison</li>
					<li onclick="aajax('metrics/dashboard', 0)" class="ajax" >Дашборды</li>
					<li><?=$_GET['param'];?></li>
				</ul>
				</div>
			<?

			include ($_SERVER['DOCUMENT_ROOT'].'/app/edison/metrics/boards/'. $_GET['param'] .'.php');
		}
	?>

<!-- </div> -->