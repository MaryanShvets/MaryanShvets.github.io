
<div id="login-form-container">
	<div id="login-form-container-inner" style="background:white;">

		<div id="login-form" class="ui-shaddow ui-round" data-status="notactive">

			<h1>Вход</h1>

            <br>

			<input id="email" class="input" name="email" value="" type="text"  placeholder="Email"><br>
	        <div id="sub" class="ui-btn submit">Войти</div>

		</div>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() { 

        $("#login-form").change(function(){

            var email = $('#email').val();

            // if (email !=0 ) {

                // $('.submit').addClass('active');

                // $("#sub").click(function (){
                //     signin();   
                // });
            // };

            // if(email != 0){
                if(isValidEmailAddress(email)){
                    $('.submit').addClass('active');

                    $("#sub").click(function (){
                        signin();   
                    });
                } else {
                    $("#email").css({
                        "border": "1px solid red"
                    });
                }
            // } else {
            //     $("#email").css({
            //         "border": "1px solid red"
            //     }); 
            // }

        });

    });  

    function signin() {

        var email = $('#email').val();
        var status =  $('#login-form').attr('data-status');

        if (status == 'notactive') {

            $('#login-form').attr('data-status', 'active');

            $.ajax({
              type: "POST",
              url: '/app/core/affilate/user_signin.php',
              data: {
                email: email
              }
            })
            .done(function(data) {
              
                if (data == 'notfound') {
                    $('#login-form').html('<p>Такой пользователь не найден в системе</p>');
                }
                else
                {
                    $('#login-form').html('<p>Ссылка для входа на почте</p>');
                }
                
            });
        }
        // if ($) {}

        // if ($) {}

        // $('#login-form').attr('data-status', 'active');

       
    }


	function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }
</script>