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

		<h1>База знаний</h1>

		<div id="result">
			
		</div>

		
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

			var url = $(location).attr('search');

			$.ajax({
	           type: "GET",
	           url: '/app/control/api/control/get_trello.php',
	           data: url,
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