<html>
<head>
	<title>Выставить счет</title>

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/header.php');

	?>

</head>	
<body class="page-finance">

	<?
		include( $_SERVER['DOCUMENT_ROOT'].'/app/control/frontend/blocks/menu.php');
	?>

	<div id="content">

		<form id="form" style="margin-left: 25px; background: #ececec; display: inline-block; padding: 10px; border-radius: 3px;">
			<select name="system" id="system">
				<option value="default">Система</option>
				<option value="fondy">Fondy</option>
				<option value="walletone">Walletone</option>
				<option value="yandex-money">Yandex</option>
			</select><br>
			<select name="currency" id="currency">
				<option value="default">Валюта</option>
				<option value="UAH">UAH</option>
				<option value="USD">USD</option>
				<option value="RUB">RUB</option>
				<option value="EUR">EUR</option>
			</select>
			<input type="text" name="summ" id="summ" placeholder="Сумма"><br>

			
			<input type="text" name="email" id="email" style="width:350px;" placeholder="E-mail клиента"><br>
			<input type="text" name="desc" id="desc" style="width:350px;" placeholder="Описание платежа"><br> 
			<input type="text" name="amoLead" id="amoLead" style="width:350px;" placeholder="ID AmoCRM"><br> 
			
		</form>
			<br>
		<div id="submit" style="margin-left:25px;margin-top: 25px;" class="not-active mb-60 btn green">Отправить</div>

		<p id="result"></p>

		<br>
		<br>
		<p id="info" style="display: none;"></p>
	</div>


	<div id="loading">
		<div class="cssload-container">
			<div class="cssload-whirlpool"></div>
		</div>

		<p>Формируем счет</p>
	</div>

	<script type="text/javascript">
		$(document).ready(function() { 

			$('#form select').change(function(){

		        if ($(this).val()!=='default') {
		            $(this).addClass('good');
		        }
		        if ($(this).val()==='default') {
		            $(this).removeClass('good');
		        }

		      	if($( "select[name='system']" ).val()==='walletone'){
		      		$('#form select#currency option[value=RUB]').attr('selected','selected');
		            $('#form select#currency').addClass('good');
		            $('p#info').text('❗️ Walletone работает только в рублях.');
		            $('p#info').fadeIn();
		      	}

		      	if($( "select[name='system']" ).val()==='yandex-money'){
		      		$('#form select#currency option[value=RUB]').attr('selected','selected');
		            $('#form select#currency').addClass('good');
		            $('p#info').text('❗️Яндекс.Деньги работают только в рублях.');
		            $('p#info').fadeIn();
		      	}

		      	if($( "select[name='system']" ).val()=== 'fondy' && $( "select[name='currency']" ).val() === 'RUB' ){
		            // $('#form select#currency option[value=RUB]').attr('selected','selected');
		            // $('#form select#currency').addClass('good');
		            $('p#info').text('❗️  Fondy не работает с рублями. Пожалуйста, выбери Walletone или Яндекс.');
		            $('#form select#currency').removeClass('good');
		            $('p#info').fadeIn();
		      	}else{
		      		$('p#info').fadeOut();
		      	}

		      	if($( "select[name='system']" ).val()=== 'fondy' || $( "select[name='system']" ).val()=== 'default' ){
		            // $('p#info').fadeOut();
		      	}



		      	if($( "select[name='currency']" ).val()!=='RUB' && $( "select[name='system']" ).val()==='walletone'){
		            $('#form select#currency').removeClass('good');
		      	}

		      	if($( "select[name='currency']" ).val()!=='RUB' && $( "select[name='system']" ).val()==='yandex-money'){
		            $('#form select#currency').removeClass('good');
		      	}
		    });

			$( "#form input#amoLead" ).focusin(function() {
		            $('p#info').fadeIn();
		            $('p#info').html('<span style="color:red">Неправильно:</span> https://samoilov.amocrm.ru/leads/detail/32517476<br><span style="color:green">Правильно:</span> 32517476');
			});
			
			$( "#form input#amoLead" ).focusout(function() {
		            $('p#info').fadeOut();
		            
			});
			

		    $('#form input#summ').change(function(){

		        if ($(this).val().length >= 0) {
		            $(this).addClass('good');
		        }
		        if ($(this).val().length <= 0) {
		            $(this).removeClass('good');
		        }
		        
		    });

		    $('#form input#amoLead').change(function(){

		        if ($(this).val().length >= 5 && $(this).val().length <= 10) {
		            $(this).addClass('good');
		        }
		        if ($(this).val().length <= 5 && $(this).val().length >= 10) {
		            $(this).removeClass('good');
		        }
		        
		    });

		    $('#form input#email').change(function(){

		        if ($(this).val().length >= 2) {
		            $(this).addClass('good');
		        }
		        if ($(this).val().length <= 2) {
		            $(this).removeClass('good');
		        }
		        
		    });

		   
		    $('#form input#desc').change(function(){

		        if ($(this).val().length >= 2) {
		            $(this).addClass('good');
		        }
		        if ($(this).val().length <= 2) {
		            $(this).removeClass('good');
		        }
		        
		    });

			$("#form").change(function (){


		        var all_elements = $('select, input, textarea').length;
		        var good_elements = $('select.good, input.good, textarea.good').length;

		        // alert(good_elements);

		        if (all_elements == good_elements) {

		            // alert('good');

		            $("#submit").removeClass('not-active').addClass('active');

		            // $("body").one("click", '#submit', function(){
		            // 	$("#submit").addClass('not-active');
		            // 	$('#loading').fadeIn();
		            //     publish();
		            // });

		            $("#submit").unbind('click').bind('click', function () { 

		            	$("#submit").addClass('not-active');
		            	$('#loading').fadeIn();
		                publish();

		            });
		            
		            // $("#submit").click(function (){
		            // 	$("#submit").addClass('not-active');
		            // 	$('#loading').fadeIn();
		            //     publish();   
		            // });

		        }else{

		        }

		    });
		});

		function publish(){


				 $.ajax({
		           type: "POST",
		           url: '/app/control/api/control/new_invoice.php',
		           data: $("#form").serialize(),
		           success: function(data)
		           {
		               window.location.replace("http://polza.com/app/control/?view=invoice-list");
		           }
			         }).done(function() {
					  $('#loading').fadeOut();
					});


		}
	</script>
</body>
</html>