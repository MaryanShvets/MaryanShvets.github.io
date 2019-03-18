<?
	
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
	include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');
	$bots_memory = Memory::load('bots_config');

	$id=$_GET['param'];

?>

<div class="container dashboard">
	
	<ul class="breadlike-nav">
		<li onclick="aajax('control/bot-list', 0)" class="ajax" >УПРАВЛЕНИЕ БОТАМИ</li>
		<li><?=$id;?></li>
	</ul>

	<br>

	<form id="form" style="margin-left: 1em; margin-right: 1em;">

		<input style="width:100%;" type="hidden" name="bot" id="bot" value="<?=$id;?>">

		<div class="grid-padded">
			
			<div class="grid block">

				<div class="col col-2">
					<label >ID</label>
					<input style="width:100%;" type="text" name="id" id="id" value="<?=$bots_memory[$id]['id'];?>">
				</div>
				<div class="col col-10">
					<label >Token</label>
					<input style="width:100%;" type="text" name="token" id="token" value="<?=$bots_memory[$id]['token'];?>">
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
	           url: '/app/core/edison/bot_edit',
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