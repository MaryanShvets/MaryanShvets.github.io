<?
	
	// include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');
	$bots_memory = Memory::load('bots_config');

?>

<div class="container database article-list">

	<ul class="breadlike-nav">
		<li>Управление ботами</li>
		<li onclick="aajax('control/bot-new', 0)" class="ajax" >Добавить</li>
	</ul>

	<?

		echo '<table cellspacing="0">';

			foreach ($bots_memory as $key => $value) {
					echo '<tr onclick="aajax(\'control/bot-edit\', \''.$key.'\')">';
						echo '<td style="width:200px;">'.$key.'</td>';
						echo '<td style="width:200px;">'.$value['id'].'</td>';
						echo '<td>'.$value['token'].'</td>';
					echo '</tr>';
			}
			
		echo '</table>';
	?>

</div>


<style type="text/css">
	table{width: 100%;margin-bottom: 50px;box-shadow: 0px 0px 5px rgb(227, 227, 227);border-radius: 2px;background: white;}
	table td{padding: 10px;border-bottom: 1px solid rgb(236, 236, 236);}
	table tr:last-child td{border-bottom: none;}
	tr:hover >td{
		background: rgb(244, 244, 244);
	}
	tr:hover{cursor: pointer;}
</style>