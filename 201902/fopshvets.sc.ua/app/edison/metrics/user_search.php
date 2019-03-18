<div class="container" >

	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<li>Большой брат</li>
	</ul>

	<form id="form" style="margin-left: 1em; margin-right: 1em;">

		<div class="grid-padded">
			
			<div class="grid block">

				<div class="col">
					<label >Введите емейл</label>
					<input style="width:100%;" type="text" name="email" id="email">
				</div>
				
			</div>
			
			<br>
			<div id="submit" class="btn">Найти</div>
		</div>
	</form>
</div>

<div class="container" id="user_search_result">

	
</div>


<style type="text/css">
	.items{
		border-bottom: 1px solid rgb(236, 236, 236);
		transition: all 0.5s;
		margin: 5px;
		box-shadow: 0px 0px 5px rgb(227, 227, 227);
		border: 1px solid white;
		padding: 10px 20px;
		border-radius: 10px;
		margin-right: 10px;
		display: inline-block;
		box-sizing: border-box;
		text-align: left;
		width: 100%;
		background: white;
	}
</style>


<script type="text/javascript">
	$(document).ready(function() { 

		$('body,html').animate({
            scrollTop: 0
        }, 400);

		$('#submit').click(function(){

			loader('on');

			 $.ajax({
	           type: "GET",
	           url: '/app/core/edison/user_search',
	           data: $("#form").serialize(),
	           success: function(data)
	           {
	               // alert(data); // show response from the php script.
	           }
		         }).done(function(data) {

				  	loader('off');
				 	$('#user_search_result').html(data);
				  // aajax('control/funnelitems-list', 0);
				});
	  
		});


	});
</script>