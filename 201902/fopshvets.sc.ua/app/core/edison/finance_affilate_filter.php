

<form id="finance_affilate_filter" >

	<div class="grid-padded">
		
		<div class="grid">

			<div class="col">
				<label >ID партнера</label>

				<?

					if (!empty($_COOKIE['filter_affilatepayment'])) 
					{
						$form_part = 'value="'.$_COOKIE['filter_affilatepayment'].'"';
					}
					else
					{
						$form_part = '';
					}

				?>
				<input style="width:100%;" type="text" name="partner_id" id="partner_id" <?=$form_part;?> >
			</div>
			
		</div>
		
		<br>
		<!-- <div id="finance_affilate_filter_submit" class="btn">Сохранить</div> -->
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function() { 

		$('#modal_system_head').html('<span onclick="modal_system_close()">Закрыть</span><span style="margin-left:30px;" id="finance_affilate_filter_submit">Сохранить</span>');

		$('body,html').animate({
            scrollTop: 0
        }, 400);

		$('#finance_affilate_filter_submit').click(function(){

			loader('on');

			 $.ajax({
	           type: "POST",
	           url: '/app/core/edison/finance_affilate_filter_update',
	           data: $("#finance_affilate_filter").serialize(), // serializes the form's elements.
	           success: function(data)
	           {
	               // alert(data); // show response from the php script.
	           }
		         }).done(function(data) {


		          
				 
				  aajax('finance/affilate-payments', 1);
				});
	  
		});


	});
</script>