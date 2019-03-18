<?
	
	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

	API::connect();

	$id=$_GET['param'];

	$data = API::query(" SELECT * FROM `app_funnel_items` WHERE `token` ='$id' LIMIT 1");

?>

<div class="container dashboard">
	
	<ul class="breadlike-nav">
		<li onclick="aajax('control/funnelitems-list', 0)" class="ajax" >Елементы воронки</li>
		<li><?=$data['id'];?></li>
	</ul>

	<br>

	<form id="form" style="margin-left: 1em; margin-right: 1em;">

		<input style="width:100%;" type="hidden" name="token" id="token" value="<?=$data['token'];?>">

		<div class="grid-padded">
			
			<div class="grid block">

				<div class="col col-2">
					<label >ID</label>
					<input style="width:100%;" type="text" name="id" id="id" value="<?=$data['id'];?>">
				</div>
				<div class="col col-10">
					<label >Data</label>
					<input style="width:100%;" type="text" name="text" id="text" value="<?=$data['text'];?>">
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
	           url: '/app/core/edison/funnelitems_edit',
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