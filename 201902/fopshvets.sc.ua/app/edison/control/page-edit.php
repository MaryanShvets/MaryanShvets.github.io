<?
	
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

	API::connect();

	$id=$_GET['param'];

	$data = API::query(" SELECT `id`, `amoName`, `amoTags`, `amoPrice`, `price`, `amoview`, `grview`, `grNew`, `grEnd`, `URL`, `redirect`, `redirectPay`, `smsview`, `SmS`, `category`, `LMSview`, `LMScode`, `LMSkey`, `affilate_cost`, `affilate_reg`, `affilate_lp` FROM `products` WHERE `id` ='$id' LIMIT 1");

?>

<div class="container dashboard">
	
	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<li onclick="aajax('control/page-list', 0)" class="ajax" >Страницы</li>
		<li><?=$data['amoName'];?></li>
	</ul>

	<br>

	<form id="form" style="margin-left: 1em; margin-right: 1em;">

		<input style="width:100%;" type="hidden" name="id" id="id" value="<?=$data['id'];?>">

		<div class="grid-padded">
			<div class="grid block">

				<div class="col">
					<label >Ссылка на страницу</label>
					<input style="width:100%;" type="text" name="URL" id="URL" value="<?=$data['URL'];?>">
				</div>
				<div class="col">
					<label >Переадресация</label>
					<input style="width:100%;" type="text" name="redirect" id="redirect" value="<?=$data['redirect'];?>">
				</div>
				<div class="col">
					<label >Успешная оплата</label>
					<input style="width:100%;" type="text" name="redirectPay" id="redirectPay" value="<?=$data['redirectPay'];?>">
				</div>
			</div>
			<div class="grid block">

				<div class="col col-1">
					<label >Вкл / Выкл</label>
					<input style="width:100%;" type="text" name="amoview" id="amoview" value="<?=$data['amoview'];?>">
				</div>
				<div class="col">
					<label >Название сделки</label>
					<input style="width:100%;" type="text" name="amoName" id="amoName" value="<?=$data['amoName'];?>">
				</div>
				<div class="col col-3" style="display: none;">
					<label >Теги</label>
					<input style="width:100%;" type="text" name="amoTags" id="amoTags" value="<?=$data['amoTags'];?>">
				</div>
				<div class="col col-1">
					<label >Цена (р.)</label>
					<input style="width:100%;" type="text" name="amoPrice" id="amoPrice" value="<?=$data['amoPrice'];?>">
				</div>
				<div class="col col-1">
					<label >Цена ($)</label>
					<input style="width:100%;" type="text" name="price" id="price" value="<?=$data['price'];?>">
				</div>
			</div>
			<div class="grid block">
				
				<div class="col col-1">
					<label >Вкл / Выкл</label>
					<input style="width:100%;" type="text" name="grview" id="grview" value="<?=$data['grview'];?>">
				</div>
				<div class="col">
					<label >Куда добавлять (E-mail)</label>
					<input style="width:100%;" type="text" name="grNew" id="grNew" value="<?=$data['grNew'];?>">
				</div>
				<div class="col">
					<label >После оплаты (E-mail)</label>
					<input style="width:100%;" type="text" name="grEnd" id="grEnd" value="<?=$data['grEnd'];?>">
				</div>
			</div>
			<div class="grid block">
				
				<div class="col col-1">
					<label >Вкл / Выкл</label>
					<input style="width:100%;" type="text" name="smsview" id="smsview" value="<?=$data['smsview'];?>">
				</div>
				<div class="col">
					<label >Текст сообщения</label>
					<input style="width:100%;" type="text" name="SmS" id="SmS" value="<?=$data['SmS'];?>">
				</div>
			</div>
			<div class="grid block">
				
				<div class="col col-1">
					<label >Вкл / Выкл</label>
					<input style="width:100%;" type="text" name="LMSview" id="LMSview" value="<?=$data['LMSview'];?>">
				</div>
				<div class="col">
					<label >Код</label>
					<input style="width:100%;" type="text" name="LMScode" id="LMScode" value="<?=$data['LMScode'];?>">
				</div>
				<div class="col">
					<label >Ключ</label>
					<input style="width:100%;" type="text" name="LMSkey" id="LMSkey" value="<?=$data['LMSkey'];?>">
				</div>
			</div>
			<div class="grid block">
				
				<div class="col col-3">
					<label >Комиссия за продажу (USD)</label>
					<input style="width:100%;" type="text" name="affilate_cost" id="affilate_cost" value="<?=$data['affilate_cost'];?>">
				</div>
				
				<div class="col col-3">
					<label >Комиссия за регистрацию (USD)</label>
					<input style="width:100%;" type="text" name="affilate_reg" id="affilate_reg" value="<?=$data['affilate_reg'];?>">
				</div>
				<div class="col">
					<label >Ссылка на лендинг</label>
					<input style="width:100%;" type="text" name="affilate_lp" id="affilate_lp" value="<?=$data['affilate_lp'];?>">
				</div>
			</div>
			<br>
			<div id="submit" class="btn">Отправить</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function() { 

		$('body,html').animate({
            scrollTop: 0
        }, 400);

		$('#submit').click(function(){

			loader('on');

			 $.ajax({
	           type: "POST",
	           url: '/app/core/edison/page_edit',
	           data: $("#form").serialize(), // serializes the form's elements.
	           success: function(data)
	           {
	               // alert(data); // show response from the php script.
	           }
		         }).done(function(data) {
				 
				 	 modal_info('Сохранено');
				  loader('off');

				});

	   //       $.ajax({
				//   url: "test.html",
				//   context: document.body
				// }).done(function() {
				//   $( this ).addClass( "done" );
				// });
		});


	});
</script>