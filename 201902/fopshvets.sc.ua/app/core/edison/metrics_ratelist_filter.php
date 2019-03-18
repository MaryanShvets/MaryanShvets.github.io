<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');

$list_groups = Memory::load('list_groups');

?>

<form id="metrics_ratelist_filter" >

	<div class="grid-padded">
		
		<div class="grid">

			<div class="col">
				<label >Email студента</label>

				<?

					if (!empty($_COOKIE['filter_rates_student'])) 
					{
						$form_part_student = 'value="'.$_COOKIE['filter_rates_student'].'"';
					}
					else
					{
						$form_part_student = '';
					}

				?>
				<input style="width:100%;" type="text" name="filter_rates_student" id="filter_rates_student" <?=$form_part_student;?> >
				
				<br>

				<select name="filter_rates_course">

					<?

						if (empty($_COOKIE['filter_rates_course'])) 
						{
							echo ' <option value="0">Выбрать курс</option>';
							foreach ($list_groups as $key => $value) {
								echo ' <option value="'.$key.'">'.$key.'</option>';
							}
						}
						else
						{
							echo ' <option value="0">Отменить выбор курса</option>';
							foreach ($list_groups as $key => $value) 
							{
								if ($key == $_COOKIE['filter_rates_course']) 
								{
									echo ' <option selected value="'.$key.'">'.$key.'</option>';
								}
								else
								{
									echo ' <option value="'.$key.'">'.$key.'</option>';
								}
								
							}
						}
					?>
				</select>
			</div>
			
		</div>
		
		<br>
		<!-- <div id="finance_affilate_filter_submit" class="btn">Сохранить</div> -->
	</div>
</form>

<style type="text/css">
	select{
		background: url(data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0Ljk1IDEwIj48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6I2ZmZjt9LmNscy0ye2ZpbGw6IzQ0NDt9PC9zdHlsZT48L2RlZnM+PHRpdGxlPmFycm93czwvdGl0bGU+PHJlY3QgY2xhc3M9ImNscy0xIiB3aWR0aD0iNC45NSIgaGVpZ2h0PSIxMCIvPjxwb2x5Z29uIGNsYXNzPSJjbHMtMiIgcG9pbnRzPSIxLjQxIDQuNjcgMi40OCAzLjE4IDMuNTQgNC42NyAxLjQxIDQuNjciLz48cG9seWdvbiBjbGFzcz0iY2xzLTIiIHBvaW50cz0iMy41NCA1LjMzIDIuNDggNi44MiAxLjQxIDUuMzMgMy41NCA1LjMzIi8+PC9zdmc+) no-repeat 95% 50%;
		-moz-appearance: none; 
		-webkit-appearance: none; 
		appearance: none;
		margin-top: 10px;
		font-size: 16px;
		padding: 10px 15px;
		display: inline-block;
		border: 1px solid rgb(223, 223, 223);
		background: white;
	}
	select option{}
</style>


<script type="text/javascript">
	$(document).ready(function() { 

		$('#modal_system_head').html('<span onclick="modal_system_close()">Закрыть</span><span style="margin-left:30px;" id="metrics_ratelist_filter_submit">Сохранить</span>');

		$('body,html').animate({
            scrollTop: 0
        }, 400);

		$('#metrics_ratelist_filter_submit').click(function(){

			loader('on');

			 $.ajax({
	           type: "POST",
	           url: '/app/core/edison/metrics_ratelist_filter_update',
	           data: $("#metrics_ratelist_filter").serialize(), // serializes the form's elements.
	           success: function(data)
	           {
	               // alert(data); // show response from the php script.
	           }
		         }).done(function(data) {


		          
				 
				  aajax('metrics/rates-list', 1);
				});
	  
		});


	});
</script>