<div class="container">

	<?

		include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');

		$api = new API();
		$api->connect();

		$id = $_GET['param'];
		$data = $api->query(" SELECT * FROM `app_database` WHERE `id` = '$id' LIMIT 1 ");

	?>

	<ul class="breadlike-nav">
		<!-- <li onclick="aajax('home/start', 0)" class="ajax" >Edison</li> -->
		<li onclick="aajax('database/article-list', 0)"  class="ajax" >База знаний</li>
		<li ><?=$data['title'];?></li>
	</ul>

	<?

		echo '<textarea class="block" id="article-title">';
			echo $data['title'];
		echo '</textarea>';
	
		echo '<textarea class="block" id="article-content">';
			echo $data['text'];
		echo '</textarea>';

	?>

	<!-- <textarea></textarea> -->

	<script type="text/javascript">
		$('document').ready(function(){

			$('textarea#article-content').keyup(function(){
				
				var data = $('textarea#article-content').val();

				$('textarea#article-content').css('box-shadow','0px 0px 30px rgb(227, 227, 227)');

				$.ajax({
		           type: "POST",
		           url: '/app/core/edison/article_edit',
		           data: {id:<?=$id?>, text: data}, // serializes the form's elements.
		           success: function(data)
		           {
		               // alert(data); // show response from the php script.
		           }
		         }).done(function(data) {
		         	$('textarea#article-content').css('box-shadow','0px 0px 0px rgb(227, 227, 227)');
				});

			});

			$('textarea#article-title').keyup(function(){
				
				var data = $('textarea#article-title').val();
				
				$('textarea#article-title').css('box-shadow','0px 0px 30px rgb(227, 227, 227)');

				$.ajax({
		           type: "POST",
		           url: '/app/edison/api/article_edit.php',
		           data: {id:<?=$id?>, title: data}, // serializes the form's elements.
		           success: function(data)
		           {
		               // alert(data); // show response from the php script.
		           }
		         }).done(function(data) {
		         	$('textarea#article-title').css('box-shadow','0px 0px 0px rgb(227, 227, 227)');
				});

			});

			$('#article-content').on( 'change keyup keydown paste cut', 'textarea', function (){
		    $(this).height(0).height(this.scrollHeight);
		}).find( 'textarea' ).change();
		});
		
	</script>
	
</div>

<style type="text/css">
	textarea{
		border: none;
		width: 100%;
		font-size: 18px;
		padding: 20px;
		font-weight: 100;
		margin: auto;
		margin-top: 20px;
		margin-bottom: 20px;
		box-sizing: border-box;
		border-radius: 2px;
		transition: all 0.6s;
	}
	textarea#article-content{
		min-height: 650px;
	}
</style>
<!-- 

<style type="text/css">
	table{width: 100%;margin-bottom: 50px;box-shadow: 0px 0px 5px rgb(227, 227, 227);border-radius: 2px;}
	table td{padding: 10px;border-bottom: 1px solid rgb(236, 236, 236);}
	table tr:last-child td{border-bottom: none;}
	tr:hover >td{
		background: rgb(244, 244, 244);
	}
</style> -->