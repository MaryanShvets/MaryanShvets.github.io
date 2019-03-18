// $('body').ready(function(){

function aajax(href, param){

	loader('on');

	$('#content').css('opacity','0');

	if (param == 0) {

		var new_url = 'http://polza.com/app/edison/'+href;
		var send_url = '/app/edison/'+href+'.php';
	}else{

		var new_url = 'http://polza.com/app/edison/'+href+'/'+param;
		var send_url = '/app/edison/'+href+'.php?param='+param;
	}

	$('#menu-box').removeClass('active');
		$('#menu-box').css('top','-250px');
		$('#content').css('margin-top','100px');

	$.ajax({
       type: "GET",
       url: send_url,
       data:{}
         })
			.done(function(data) {

			window.history.pushState("object or string", "Title", new_url);

         	$('#content').html(data);

         	loader('off');

       		$( "#content" ).animate({
				opacity: "1",
			}, 1000, function() {
				
			});

			$('body,html').animate({
	            scrollTop: 0
	        }, 400);
	});
}

// function pageLoad_dialogs(){
// 	$.ajax({
//        type: "GET",
//        url: '/api/chat/dialogs_get',
//        data:{}
//          })
// 			.done(function(data) {

//          	$('#chat-dialogs-list').html(data);
// 	});
// }

function loader(t){
	if(t=='on'){
		$('#loading').fadeIn(300);
	}else if(t=='off'){
		$('#loading').fadeOut(300);
	}
}

function modal_info(text){
	
	$('#modal_info_box #text').text(text);
	$('#modal_info_box').fadeIn(300);

	setTimeout(function() { 

		$('#modal_info_box').fadeOut(300);

	}, 1000);
}

function aajax_privat(id, i, p, c){

	var send_url = '/app/core/edison/finance_balance_privat';

	$.ajax({
       type: "GET",
       url: send_url,
       data:{id:i, pass:p, card:c}
         })
			.done(function(data) {

			var target_block = $('#privat_'+id);
			$(target_block).text(data);
	});
}

function aajax_fondy(id, i, p){

	var send_url = '/app/core/edison/finance_balance_fondy';

	$.ajax({
       type: "GET",
       url: send_url,
       data:{id:i, pass:p}
         })
			.done(function(data) {

			var target_block = $('#fondy_'+id);
			$(target_block).text(data+'.00 UAH');
	});
}

function aajax_finance_income(){

	var send_url = '/app/core/edison/finance_income';

	$.ajax({
       type: "GET",
       url: send_url,
       data:{}
         })
			.done(function(data) {
			var target_block = $('#finance_income');
			$(target_block).text(data);
	});
}

function menu_box(){

	if ($('#menu-box').hasClass('active')) {
		$('#menu-box').removeClass('active');
		$('#menu-box').css('top','-250px');
		// $('#content').css('margin-top','100px');
	}else{


		$('#menu-box').addClass('active');
		// $('#menu-box').toggle(300);
		$('#menu-box').css('top','25px');
		// $('#content').css('margin-top','300px');
	}

	// $('#menu-box').toggle(300);
}

function aajax_system(time, k1, k2, k3, k4, k5){

	$('#modal_system').fadeIn(300);

	$( "#modal_system #modal_system_inside" ).animate({
		    right: "0",
		  }, 500, function() {
		    // Animation complete.
		  });

	var send_url = '/app/core/edison/system_get';

	$.ajax({
       type: "GET",
       url: send_url,
       data:{time:time, key1:k1, key2:k2, key3:k3, key4:k4, key5:k5, }
         })
			.done(function(data) {

				$('#modal_system').fadeIn(300);
				$('#modal_system #modal_system_content').html(data);
				
	});
}


function aajax_vk_ad_get(id){

	$('#modal_system').fadeIn(300);

	$( "#modal_system #modal_system_inside" ).animate({
		    right: "0",
		  }, 500, function() {
		    // Animation complete.
		  });

	var send_url = '/app/core/edison/vk_ad_get';

	$.ajax({
       type: "GET",
       url: send_url,
       data:{id:id }
         })
			.done(function(data) {

				$('#modal_system').fadeIn(300);
				$('#modal_system #modal_system_content').html(data);
	});

}

function aajax_affilate_status(id, type)
{

	var curent_id = '#affilate_control_'+type+'_'+id;
	var curent_status = $(curent_id).attr('data-status');
	var next_status;
	var next_text;
	var next_api_status;

	if (type == "aprove") 
	{
		next_text = "👥";
	}
	else
	{
		next_text = "💰";
	}

	if (curent_status=="no") 
	{
		next_status = "yes";
		next_text = next_text + "✅";
	}
	else if(curent_status == "yes")
	{
		next_status = "no";
		next_text = next_text + "❌";
	}

	if (curent_status == "yes" || curent_status == "no") {

		$(curent_id).text("⏳");

		$.ajax({
	       type: "POST",
	       url: "/app/core/edison/finance_affilate_status",
	       data:{id:id, type:type, status:next_status }
	         })
				.done(function(data) {

					$(curent_id).text(next_text);
					$(curent_id).attr('data-status', next_status);

					if (type == "aprove" && next_status == "yes") {
						$('#affilate_control_paid_'+id).addClass("yes").removeClass("block");
						$('#affilate_control_paid_'+id).attr("data-status", "no");
					}
					else if(type == "aprove" && next_status == "no")
					{
						$('#affilate_control_paid_'+id).addClass("block").removeClass("yes");
						$('#affilate_control_paid_'+id).attr("data-status", "block");
						$('#affilate_control_paid_'+id).text("💰❌");
					}
		});

		// setTimeout(function()
		// {
		//  	$(curent_id).text(next_text);
		// 	$(curent_id).attr('data-status', next_status);

		// 	if (type == "aprove" && next_status == "yes") {
		// 		$('#affilate_control_paid_'+id).addClass("yes").removeClass("block");
		// 		$('#affilate_control_paid_'+id).attr("data-status", "yes");
		// 	}

		// }, 1000);
	}
}



function aajax_affilate_info(id){

	$('#modal_system').fadeIn(300);

	$( "#modal_system #modal_system_inside" ).animate({
		    right: "0",
		  }, 500, function() {
		    // Animation complete.
		  });

	var send_url = '/app/core/edison/finance_affilate_info';

	$.ajax({
       type: "POST",
       url: send_url,
       data:{ id:id}
         })
			.done(function(data) {

				$('#modal_system').fadeIn(300);
				$('#modal_system #modal_system_content').html(data);
				
	});
}

function aajax_filter_affilatepayment_open(){

	$('#modal_system').fadeIn(300);

	$( "#modal_system #modal_system_inside" ).animate({
		    right: "0",
		  }, 500, function() {
		    // Animation complete.
		  });

	var send_url = '/app/core/edison/finance_affilate_filter';

	$.ajax({
       type: "POST",
       url: send_url,
       data:{}
         })
			.done(function(data) {

				$('#modal_system').fadeIn(300);
				$('#modal_system #modal_system_content').html(data);
				
	});
}

function aajax_filter_metricsrateslist_open(){

	$('#modal_system').fadeIn(300);

	$( "#modal_system #modal_system_inside" ).animate({
		    right: "0",
		  }, 500, function() {
		    // Animation complete.
		  });

	var send_url = '/app/core/edison/metrics_ratelist_filter';

	$.ajax({
       type: "POST",
       url: send_url,
       data:{}
         })
			.done(function(data) {

				$('#modal_system').fadeIn(300);
				$('#modal_system #modal_system_content').html(data);
				
	});
}

function modal_system_close(){

$('#modal_system').fadeOut();

$( "#modal_system #modal_system_inside" ).animate({
    right: "-790px",
  }, 500, function() {
    
	setTimeout(300);
	$('#modal_system #modal_system_content').html('<div id="modal_loading"><div class="cssload-container"><ul class="cssload-flex-container"><li><span class="cssload-loading"></span></li></div></div></div>');

  });

}

function rate_change_state(id)
{
	var curent_id = '#rate_'+id;

	var send_url = '/app/core/edison/rates_changestate';

	if ( $( curent_id ).hasClass( "status_0" ) ) 
	{
 		$( curent_id ).addClass("status_active");

 		$.ajax({
	       type: "POST",
	       url: send_url,
	       data:{ id:id,state:'1'}
	         })
				.done(function(data) {

				$( curent_id ).addClass("status_1").removeClass("status_0").removeClass("status_active");
		});
    }
    else
    {
    	$( curent_id ).addClass("status_active");

    	$.ajax({
	       type: "POST",
	       url: send_url,
	       data:{ id:id,state:'0'}
	         })
				.done(function(data) {

				$( curent_id ).addClass("status_0").removeClass("status_1").removeClass("status_active");
					
		});
    }
}
