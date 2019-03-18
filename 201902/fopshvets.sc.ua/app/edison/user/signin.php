
<div id="login-form-container">
	<div id="login-form-container-inner" >

		<div id="login-form" class="ui-shaddow ui-round">

			<h1>Вход</h1>

			<input id="email" class="input" name="email" value="" type="text"  placeholder="Email"><br>
			<input id="password" class="input" name="password" value="" type="password" placeholder="Password"><br>
	        

	        <div id="sub" class="ui-btn submit">Войти</div>

		</div>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() { 

        $("#login-form").change(function(){

            var email = $('#email').val();
            var password = $('#password').val();

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

            // if (email !=0 && password !=0 ) {

            //     $('.submit').addClass('active');

            //     $("#sub").click(function (){
            //         signin();   
            //     });
            // };

            // if(email != 0){
            //     if(isValidEmailAddress(email)){
            //         // $("#email").css({
            //         //     "border": "1px solid green"
            //         // });
            //     } else {
            //         $("#email").css({
            //             "border": "1px solid red"
            //         });
            //     }
            // } else {
            //     $("#email").css({
            //         "border": "1px solid red"
            //     }); 
            // }

        });

    });  

    function signin() {

        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
	      type: "POST",
	      url: '/app/edison/api/user_signin.php',
	      data: {
	        email: email,
	        pass: password
	      }
	    })
	    .done(function(data) {
	      

	      if (data == 'ok') {

                window.location.replace("http://polza.com/app/edison/");
	        };
	        if(data == 'used'){

	        	// $('#result').html('It looks like you used a wrong email or password');

	        };
	    });
    }


	function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }
</script>