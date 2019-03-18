<div class="container" >

	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<li>Поиск пользователя</li>
	</ul>

	<form id="form" style="margin-left: 1em; margin-right: 1em;">

		<div class="grid-padded">
			
			<div class="grid block">

				<!-- <div class="col">
					<label >Введите имя</label>
					<input style="width:100%;" type="text" name="name" id="name" placeholder="Имя">
				</div>

				<div class="col">
					<label >Введите телефон</label>
					<input style="width:100%;" type="text" name="phone" id="phone" placeholder="Телефон">
				</div> -->

				<div class="col">
					<label >Введите емейл</label>
					<input style="width:100%;" type="text" name="email" id="email" placeholder="Емейл">
				</div>

				<div class="col col-1">
					<div id="submit" class="btn">Найти</div>
				</div>
				
			</div>
			
		</div>
	</form>
</div>

<div class="container" id="client_search_result">

	
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
		
	}
	.btn{
		/*color: white;*/
		/*background: #0f82f6;*/
	}
	.btn:hover{
		/*color: white;*/
	}
	table{
		box-shadow: 0px 0px 5px rgb(227, 227, 227);
		background: white;
		margin-bottom: 50px;
		border-radius: 2px;
		width: 100%;
		/*margin-left: 1em; 
		margin-right: 1em;*/
	}
	tr{
		/* display: block; */
		margin: auto;
		margin-top: 5px;
		margin-bottom: 5px;
		padding: 10px;
		width: 100%;
		/* border-bottom: 1px solid black; */
		background: white;
		/*box-shadow: 0px 2px 5px rgb(202, 202, 202);*/
		box-sizing: border-box;
		border-radius: 2px;
		transition: all 0.6s;
	}
	td{
		padding: 20px;
		border-bottom: 1px solid rgb(236, 236, 236);
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
	           type: "POST",
	           url: '/app/core/edison/client_search',
	           data: $("#form").serialize(),
	           success: function(data)
	           {
	               // alert(data); // show response from the php script.
	           }
		         }).done(function(data) {

				  	loader('off');
				 	$('#client_search_result').html(data);
				  // aajax('control/funnelitems-list', 0);
				});

		});


	});
</script>