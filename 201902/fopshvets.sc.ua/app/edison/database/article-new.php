<div class="container dashboard">
	
	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<li onclick="aajax('database/article-list', 0)"  class="ajax">База знаний</li>
		<li>Создать</li>
	</ul>

	<br>

	<form id="form" style="margin-left: 1em; margin-right: 1em;">

		<div class="grid-padded">
			
			<div class="grid block">

				<div class="col">
					<label >Название материала</label>
					<input style="width:100%;" type="text" name="title" id="title">
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

			var data = $('#title').val();

			 $.ajax({
	           type: "POST",
	           url: '/app/core/edison/article_new',
	           data: {title: data}, // serializes the form's elements.
	           success: function(data)
	           {
	               // alert(data); // show response from the php script.
	           }
		         }).done(function(data) {
				 
				  aajax('database/article-list', 0)
				});

	  
		});


	});
</script>