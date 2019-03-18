<html>
<head>
	<title>Платежи Приват24</title>

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/header.php');

	?>

</head>	
<body class="page-payments-list">

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/menu.php');
	?>

	<div id="content">

		<h1>Платежи Приват24</h1>

		<table id="result">
			
		</table>

		
	</div>

	<div id="loading">
		<div class="cssload-container">
			<div class="cssload-whirlpool"></div>
		</div>

		<p>Выгружаем платежи</p>
	</div>
	
	<script type="text/javascript">
		$('document').ready(function(){
			$('#loading').fadeIn();

			$.ajax({
	           type: "POST",
	           url: '/app/api/privatbank/control/get_payments.php',
	           success: function(data)
	           {
	           		$('#result').html(data);
	           		$('#loading').fadeOut();
	               // window.location.replace("http://polza.com/app/control/?view=invoice-list");
	           }
		         }).done(function() {
		         	$('#result').html(data);
	           		$('#loading').fadeOut();
				});
		});
	</script>
</body>
</html>