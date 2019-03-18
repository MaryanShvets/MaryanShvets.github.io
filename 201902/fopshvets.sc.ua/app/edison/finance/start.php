<?

		?>

			<div class="container dashboard">
			<ul class="breadlike-nav">
				<li onclick="aajax('home/start', 0)" class="ajax" >Edison</li>
				<li>Финансы</li>
			</ul>
			
		<?

		echo '<a onclick="aajax(\'finance/payments\', \'0\')" class="item ajax btn">Платежи</a>';
		echo '<a onclick="aajax(\'finance/balance\', \'0\')" class="item ajax btn">Баланс</a>';

		echo '</div>';
	
?>