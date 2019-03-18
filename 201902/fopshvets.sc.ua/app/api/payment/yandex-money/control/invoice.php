<?php

  $fin_data = json_decode(file_get_contents('http://polza.com/app/api/payment/config.json'));
	$card = $fin_data->yandex_card;

	include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
	$api = new API();
	$api->connect();

	$id = $_GET['id'];

	$invoice_id = $_GET['id'];
	$invoice_info = $api->query(" SELECT * FROM `app_payments` WHERE `id` = '$id' LIMIT 1 ");

	$pay_channel = 'yandex-money';
	$status = 'active';

	// Записываем данные
	$date_mod = date("Y-m-d H:i:s", strtotime('+7 hours'));
	$api->query(" UPDATE `app_payments` SET `pay_system`='$pay_system', `status`='$status', `date_mod`='$date_mod' WHERE `id` = '$invoice_id' ");   
  
?>
<html>
  <head>
    <META NAME="ROBOTS" CONTENT="NOINDEX">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="http://polza.com/polza.main.css" rel="stylesheet" type="text/css">
    <title>Оплата</title>

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
  p {
    border-bottom: 1px solid rgba(211, 212, 213, 0.99);
    font-weight: 600;
    text-align: right;
    padding-bottom: 8px;
} 
p:last-child {
    border-bottom: 0px;
}
  p span {
    display: inline-block;
    float: left;
    font-weight: 400;
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
input{
    background: #01bfa5;
    font-weight: 200;
    border-radius: 3px;
    padding: 10px 15px;
    box-sizing: border-box;
    font-size: 16px;
    color: white;
    text-align: center;
    border: none;
    box-shadow: 1px 1px 5px #bfbfbf;
  transition: all 1s;
}
input:hover{
    box-shadow: 3px 3px 7px #bfbfbf;
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
  
}

  </style>
  </head>
  <body>
    <div class="container">
    <div class="row mb-60">
      <div class="col-md-3"></div>
      <div class="col-md-6 bg-w mt-20">
          <h1 class="text-center fs-24 pb-20"><?=$invoice_info['order_desc']?></h1>
          
          <div class="row pb-60">
            <div class="col-md-3"></div>
            <div class="col-md-6 mt-30">
          	<form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml"> 
  				    <input type="hidden" name="receiver" value="<?=$card?>"> 
  				    <!-- <input type="hidden" name="formcomment" value="Проект «Железный человек»: реактор холодного ядерного синтеза">  -->
  				    <!-- <input type="hidden" name="short-dest" value="Проект «Железный человек»: реактор холодного ядерного синтеза">  -->
  				    <input type="hidden" name="label" value="<?=$id;?>"> 
  				    <input type="hidden" name="quickpay-form" value="shop"> 
  				    <input type="hidden" name="targets" value="<?=$invoice_info['order_desc']?>"> 
  				    <input type="hidden" name="sum" value="<?=$invoice_info['pay_amount']?>" data-type="number"> 
  				    <!-- <input type="hidden" name="comment" value="Хотелось бы дистанционного управления.">  -->
  				    <!-- <input type="hidden" name="need-fio" value="true">  -->
  				    <input type="hidden" name="need-email" value="true"> 
  				    <!-- <input type="hidden" name="need-phone" value="false">  -->
  				    <!-- <input type="hidden" name="need-address" value="false">  -->
  				    <!-- <label><input type="radio" name="paymentType" value="PC">Яндекс.Деньгами</label>  -->
  				    <!-- <label><input type="radio" name="paymentType" value="AC">Банковской картой</label>  -->
  				    <input type="submit" value="Оплатить через Яндекс.Деньги"> 
				  </form>
            </div>
          </div>
          <div class="row" id="secure">
            <div class="col-md-4 text-center">
              <img class="grayscale" src="http://vizi.net.ua/custom_css/images/verified-by-visa.png">
            </div>
            <div class="col-md-4 text-center">
              <img class="grayscale" src="https://www.oplata.com/static/v1/files/logos/mastercard-securecode.png">
            </div>
            <div class="col-md-4 text-center">
              <img class="grayscale" src="http://www.tadviser.ru/images/thumb/5/5a/PCI_DSS_3-2.png/680px-PCI_DSS_3-2.png">
            </div>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center fs-12 pb-20">
        © polza.com Все права защищены. <a target="_blank" href="http://polza.com/publichnyiy-dogovor/">Публичный договор</a>.<br>
        По всем вопросам: zabota@polza.com, +7 499 753 34 43, +7 771 72 72 39
      </div>
    </div>
  </body>
</html>