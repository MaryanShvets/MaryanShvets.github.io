<html>
<head>
	<title>Финансовая система</title>

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/header.php');

	?>

</head>	
<body class="page-finance">

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/menu.php');
	?>

	<div id="content">

		<h1>Финансовая система</h1>

		<ul id="status">
			<li><a <?if(empty($_GET['status'])){echo 'class="active"';}?> href="/app/control/?view=finance">Системы</a></li>
			<li><a <?if($_GET['status']=='payments'){echo 'class="active"';}?> href="/app/control/?view=finance&status=payments">Платежи</a></li>
			<li><a <?if($_GET['status']=='balance'){echo 'class="active"';}?> href="/app/control/?view=finance&status=balance">Баланс</a></li>
			<!-- <li><a <?if($_GET['status']=='moneyflow'){echo 'class="active"';}?> href="/app/control/?view=finance&status=moneyflow">Выписка</a></li> -->
		</ul>

		<?
				
			$api->connect();

			if(empty($_GET['status'])){

				include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/finance-system.php');

			}elseif($_GET['status']=='balance'){

				include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/finance-balance.php');

			}elseif($_GET['status']=='moneyflow'){

				include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/finance-moneyflow.php');
				
			}elseif($_GET['status']=='payments'){

				include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/finance-payments.php');
			}

		?>
		
	</div>
</body>
</html>