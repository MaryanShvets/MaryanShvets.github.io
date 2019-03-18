<?
	
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

	API::connect();

	$id=$_GET['param'];

	$data = API::query(" SELECT * FROM `app_payments_config` WHERE `id` ='$id' LIMIT 1");

?>

<div class="container dashboard">
	
	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<!-- <li onclick="aajax('finance/start', 0)" class="ajax" >Финансы</li> -->
		<li onclick="aajax('finance/config-list', 0)" class="ajax" >Список фин. систем</li>
		<li><?=$data['description'];?></li>
	</ul>

	<br>

	<form id="form" style="margin-left: 1em; margin-right: 1em;">

		<input style="width:100%;" type="hidden" name="id" id="id" value="<?=$data['id'];?>">

		<div class="grid-padded">
			
			<div class="grid block">

				<div class="col col-2">
					<label >Система</label>
					<input style="width:100%;" type="text" name="system" id="system" value="<?=$data['system'];?>">
				</div>
				<div class="col col-2">
					<label >Статус (active / pause)</label>
					<input style="width:100%;" type="text" name="status" id="status" value="<?=$data['status'];?>">
				</div>
				<div class="col">
					<label >Описание</label>
					<input style="width:100%;" type="text" name="description" id="description" value="<?=$data['description'];?>">
				</div>
			</div>

			<div class="grid block">

				<div class="col">
					<label >Ключ 1</label>
					<input style="width:100%;" type="text" name="key1" id="key1" value="<?=$data['key1'];?>">
				</div>
				<div class="col">
					<label >Ключ 2</label>
					<input style="width:100%;" type="text" name="key2" id="key2" value="<?=$data['key2'];?>">
				</div>
				<div class="col">
					<label >Ключ 3</label>
					<input style="width:100%;" type="text" name="key3" id="key3" value="<?=$data['key3'];?>">
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
	           url: '/app/core/edison/finance_config_edit',
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