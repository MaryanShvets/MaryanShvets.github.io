<?
	
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

	API::connect();

	$id=$_GET['param'];

	$data = API::query(" SELECT * FROM `app_contact` WHERE `id` ='$id' LIMIT 1");
	$email = $data['email'];
	$bots = mysql_query(" SELECT * FROM `app_bot_list` WHERE `email` ='$email' ");

?>

<div class="container dashboard">
	
	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<li onclick="aajax('control/client-search', 0)" class="ajax" >Поиск клиентов</li>
		<li><?=$data['email'];?></li>
	</ul>

	<br>

	<form id="form" style="margin-left: 1em; margin-right: 1em;">

		<input style="width:100%;" type="hidden" name="id" id="id" value="<?=$data['id'];?>">

		<div class="grid-padded">
			<div class="grid block">

				<div class="col">
					<label >Имя</label>
					<input style="width:100%;" type="text" name="name" id="name" value="<?=$data['name'];?>">
				</div>
				<div class="col">
					<label >Телефон</label>
					<input style="width:100%;" type="text" name="phone" id="phone" value="<?=$data['phone'];?>">
				</div>
				<div class="col">
					<label >Емейл</label>
					<input style="width:100%;" type="text" name="email" id="email" value="<?=$data['email'];?>">
				</div>
			</div>
			<div class="grid block">

				<div class="col col-4">
					<label >Чей партнер</label>
					<input style="width:100%;" type="text" name="affilate" id="affilate" value="<?=$data['affilate'];?>">
				</div>

				<div class="col col-4">
					<label >Подтвержденный (0 нет, 1 да)</label>
					<input style="width:100%;" type="text" name="affilate_status" id="affilate_status" value="<?=$data['affilate_status'];?>">
				</div>
				<div class="col">
					<label >Связи с ботами</label>

					<br>

					<?
						while ($row = mysql_fetch_array($bots)) {
							echo '<span class="bot_connects">'.$row['bot'].' '.$row['messenger'].'</span>';
						}
					?>

					<!-- <input style="width:100%;" type="text" name="chatfuel" id="chatfuel" value="<?=$data['chatfuel'];?>"> -->
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
	           url: '/app/core/edison/client_edit',
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

<style type="text/css">
	.bot_connects{
		font-weight: 300;
		display: inline-block;
		margin-top: 5px;
		width: 100%;
	}
</style>