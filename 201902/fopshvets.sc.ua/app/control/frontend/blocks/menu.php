<div id="menu">
	<ul>
		<?
			$menu_list = array(
					'invoice-list'=>'Счета',
					'invoice-new'=>'Создать счет',
					// 'submits'=>'Регистрации',
					'product-list'=>'Страницы',
					// 'payments-list'=>'Приват24',
					// 'trello'=>'База знаний',
					'user-search'=>'Большой брат',
					// 'report'=>'Отчеты',
					'finance'=>'Финансы',
					'youtube'=>'YouTube'
				);

			if ($access=='admin') {
				foreach ($menu_list as $key => $value) {
					if($key == $view){$class='class="active"';}else{$class='class=""';}
					echo '<li><a '.$class.' href="/app/control/?view='.$key.'">'.$value.'</a></li>';
				}
			}
			elseif($access!=='admin'){
				foreach ($access_list[$access] as $key => $value) {
					$menu_item = $value;
					if($menu_item == $view){$class='class="active"';}else{$class='class=""';}
					echo '<li><a '.$class.' href="/app/control/?view='.$menu_item.'">'.$menu_list[$menu_item].'</a></li>';
				}
			}
		?>
		<li><a id="" href="http://polza.com/app/edison/home/start">Edison</a></li>
		<li style="position: absolute;bottom: 0px;width: 100%;"><a id="exit" href="http://polza.com/app/control/api/control/exit_login.php">Выйти</a></li>
	</ul>
</div>