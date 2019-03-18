<html>
  <head>
    <META NAME="ROBOTS" CONTENT="NOINDEX">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script
      src="https://code.jquery.com/jquery-3.1.1.min.js"
      integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
      crossorigin="anonymous"></script>
    <link href="http://polza.com/polza.main.css" rel="stylesheet" type="text/css">
    <title>Вход</title>

    <script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-5R5D4Q');
    </script>

    <style type="text/css">
      body {
            background: #eceff1;
        }
        .bg-w {
      background-color: white;
      box-shadow: 1px 5px 10px #bfbfbf;
  }
   h1 {
      /*margin-top: 20px;*/
      font-weight: 200;
      border-bottom: 1px solid #01bfa5;
      display: inline-block;
      background: white;
      width: 100%;
      /*padding-left: 10px;*/
      /*padding-top: 10px;*/
      /*padding-bottom: 10px;*/
      box-sizing: border-box;
      /*font-size: 24px;*/
  }

h3{
    background: #01bfa5;
    font-weight: 200;
    border-radius: 3px;
    padding: 10px 15px;
    box-sizing: border-box;
    font-size: 16px;
    color: white;
}

#secure {
    background: #eceff1;
}
#secure img {
    width: auto;
    height: 70px;
    text-align: center;
    padding: 20px;
    box-sizing: border-box;
}
#secure img:hover{
  filter: none;
}
a{
  text-decoration: none;
  
}
h3{
  box-shadow: 1px 1px 5px #bfbfbf;
  transition: all 1s;
}
h3:hover{
  box-shadow: 3px 3px 7px #bfbfbf;
}
a:hover{
  text-decoration: none;
  cursor: pointer;
  
}
input {
    padding: 5px 8px;
    border: 1px solid rgba(211, 212, 213, 0.99);
    font-size: 14px;
    width: 100%;
    font-weight: 200;
    margin-top: -1px;
}
input[type="text"]:focus { outline: none; }

  </style>
  </head>
  <body>
    <div class="container">
    <div class="row mb-60 mt-20">
      <div class="col-md-3"></div>
      <div class="col-md-6 bg-w">
          <h1 class="text-center fs-24 pb-20">polza.app</h1>
           
          <div class="row pt-60 pb-10">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <input type="text" name="email" id="email" placeholder="email" required><br>
              <input type="password" name="pass" id="pass" placeholder="passwords" required>
            </div>
          </div>
          <p class="text-center pt-10" id="form-status"></p>
          <div class="row pb-60">
            <div class="col-md-3"></div>
            <div class="col-md-6">
               <a id="submit" target="_blank" ><h3 class="text-center">Войти</h3></a>
            </div>
          </div>
          
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center fs-12 pb-20">
        © polza.com Все права защищены
      </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function(){
          $('#submit').click(function(){

            var email = $('#email').val();
            var pass = $('#pass').val();
            var status = $('#form-status');

            $.post( "/app/control/api/control/get_login.php", { email: email, pass: pass})
              .done(function( data ) {
                if (data == 'ok') {
                    window.location.replace("/app/control/");
                };
                if (data == 'empty') {
                    status.text('Заполните все поля 🖕');
                };
                if (data == 'wrong') {
                    status.text('Что-то не так с полями 😰');
                };
              });

          });
        });
      
    </script>

  </body>
</html>