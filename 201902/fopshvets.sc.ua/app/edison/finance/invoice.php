<!-- <div class="container dashboard">
	
	<ul class="breadlike-nav">
		<li onclick="aajax('home/start', 0)" class="ajax" >Edison</li>
		<li onclick="aajax('control/page-list', 0)" class="ajax" >Страницы</li>
		<li>Создать страницу</li>
	</ul>

	<br>

	<form id="form" style="margin-left: 1em; margin-right: 1em;">

		<div class="grid-padded">
			
			<div class="grid block">

				<div class="col">
					<label >Название сделки</label>
					<input style="width:100%;" type="text" name="amoName" id="amoName">
				</div>
				
			</div>
			
			<br>
			<div id="submit" class="btn">Отправить</div>
		</div>
	</form>
</div> -->


<div class="container">

	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<!-- <li onclick="aajax('finance/start', 0)" class="ajax" >Финансы</li> -->
		<li>Выставить счет</li>
	</ul>

	<br>

	<form id="form" style="margin-left: 1em; margin-right: 1em;">

		<div class="grid-padded">
			<div class="grid block">

				<div class="col col-2">
					<label >Кому</label>
					<input type="text" name="email" id="email" style="width:100%;" placeholder="E-mail клиента">
				</div>
				<div class="col">
					<label >Что</label>
					<input type="text" name="desc" id="desc" style="width:100%;" placeholder="Описание платежа">
				</div>
				<div class="col col-1">
					<label >Сколько</label>
					<!-- <input type="text" name="desc" id="desc" style="width:100%;" placeholder="Описание платежа"> -->
					<input type="text" name="summ" id="summ" style="width:100%;" placeholder="Сумма">
				</div>
				<div class="col col-1">
					<label >Валюта</label>
					<select name="currency" id="currency">
						<option value="default">Валюта</option>
						<option value="UAH">UAH</option>
						<option value="USD">USD</option>
						<option value="RUB">RUB</option>
						<option value="EUR">EUR</option>
					</select>
				</div>
				<!-- <div class="col">
					<label >Успешная оплата</label>
					<input style="width:100%;" type="text" name="redirectPay" id="redirectPay" value="<?=$data['redirectPay'];?>">
				</div> -->

			</div>
		</div>

		<!-- <select name="system" id="system">
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
		<input type="text" name="amoLead" id="amoLead" style="width:350px;" placeholder="ID AmoCRM"><br>  -->
		<br>
		<!-- <div id="submit" style="margin-left:25px;margin-top: 25px;" class="not-active mb-60 btn green">Отправить</div> -->

	<!-- 	<p id="result"></p>
		<br>
		<br>
		<p id="info"></p> -->
	</form>
	

	<div id="submit" class="btn">Отправить</div>
</div>

<!-- 
<div id="loading">
	<div class="cssload-container">
		<div class="cssload-whirlpool"></div>
	</div>

	<p>Формируем счет</p>
</div> -->

<style type="text/css">
	select{
		display: inline-block;
width: 100%;
display: inline-block;
border: 0;
margin: 0;
padding: 5px 10px;
box-sizing: border-box;
border: 1px solid rgb(223, 223, 223);
border-radius: 4px;
margin: 5px 0px;
font-size: 16px;
font-weight: 100;
transition: all 0.5s;
background: white;
select;
height: 30px;
	}
</style>

<script type="text/javascript">
	$(document).ready(function() { 

		// $('#form').change(function(){
		// 	text = '';

		// 	currency = $( "select[name='currency']" ).val();
		// 	summ = $( "input[name='summ']" ).val();
		// 	email = $( "input[name='email']" ).val();
		// 	desc = $( "input[name='desc']" ).val();
			
		// 	text = 'Выставляем счет на почту <b>'+email+'</b> по продукту <b>'+desc+'</b>. Стоимость <b>'+summ+' ( ' +currency+ ' )</b>';
		// 	// text = texst + ' / '+currency;
		// 	$('p#info').html(text);
		// });

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
	            	// $('#loading').fadeIn();
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
	           url: '/app/core/edison/invoice_new',
	           data: $("#form").serialize(),
	           success: function(data)
	           {
	               // window.location.replace("http://polza.com/app/control/?view=invoice-list");
	           }
		         }).done(function() {
				  	aajax('finance/payments', 0);
				});


	}
</script>