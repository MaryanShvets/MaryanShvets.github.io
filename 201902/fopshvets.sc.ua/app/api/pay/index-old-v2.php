<?php

  include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
  $api = new API();
  $api->connect();

  if(!empty($_GET['id'])){

    $id = $_GET['id'];
    $lead = $api->query(" SELECT * FROM `app_leads` WHERE `id` = '$id' LIMIT 1 ");

    $contact_id = $lead['contact'];
    $contact = $api->query(" SELECT * FROM `app_contact` WHERE `id` = '$contact_id' LIMIT 1 ");

    $product_id = $lead['product'];
    $product = $api->query(" SELECT * FROM `products` WHERE `id` = '$product_id' LIMIT 1 ");

    $name = $_GET['name'];
    $phone = $_GET['phone'];
    $email = $_GET['email'];

  }elseif(empty($_GET['id']) && !empty($_GET['product']) && !empty($_GET['email'])){

    $product_id = $_GET['product'];
    $email = $_GET['email'];

    $contact = $api->query(" SELECT * FROM `app_contact` WHERE `email` = '$email' LIMIT 1 ");
    $product = $api->query(" SELECT * FROM `products` WHERE `id` = '$product_id' LIMIT 1 ");
    $contact_id = $contact['id'];

    $lead = $api->query(" SELECT * FROM `app_leads` WHERE `contact` ='$contact_id' LIMIT 1 ");

    $name = $contact['name'];
    $phone = $contact['phone'];
    $email = $contact['email'];

  }else{

  }

  $fin_data = $api->get_fin('yandex');

  $priceCheck = round($product['amoPrice']/56.7);
  $priceCheckUAH = round($product['amoPrice']/2.1);
  
  
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
width: 100%;
box-sizing: border-box;
border-radius: 3px;
padding: 9px 15px;
box-sizing: border-box;
font-size: 16px;
margin-top: 10px;
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
      <div class="col-md-6 bg-w">
          <h1 class="text-center fs-24 pb-20">Оплата за «<?=$product['amoName']?>»</h1>
           
          <div class="row pt-60 pb-10">
            <div class="col-md-3"></div>
            <div class="col-md-6">
               <p><span>Имя:</span> <?=$name;?></p>
                <p><span>Телефон:</span> <?=$phone;?></p>
                <p><span>E-mail:</span> <?=$email;?></p>
            </div>
          </div>
          <div class="row pb-60">
            <div class="col-md-3"></div>
            <div class="col-md-6">
               <a target="_blank" href="http://polza.com/app/api/payment/fondy/control/pay.php?price=<?=$priceCheck?>&order=<?=$lead['id']?>&currency=USD&order_desc=<?=$product['amoName']?>"><h3 class="text-center">Оплатить <?=$priceCheck;?> $</h3></a>
               <a target="_blank" href="http://polza.com/app/api/payment/fondy/control/pay.php?price=<?=$priceCheckUAH;?>&order=<?=$lead['id']?>&currency=UAH&order_desc=<?=$product['amoName']?>"><h3 class="text-center">Оплатить <?=$priceCheckUAH;?> грн.</h3></a>
               <a target="_blank" href="http://polza.com/app/api/payment/walletone/control/pay.php?price=<?=$product['amoPrice'];?>&order=<?=$lead['id']?>&currency=RUB&order_desc=<?=$product['amoName']?>"><h3 class="text-center">Оплатить <?=$product['amoPrice'];?> р.</h3></a>
              
              <!-- <form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml"> 
                  <input type="hidden" name="receiver" value="<?=$fin_data['key1']?>"> 
                  <input type="hidden" name="label" value="<?=$lead['id'];?>"> 
                  <input type="hidden" name="quickpay-form" value="shop"> 
                  <input type="hidden" name="targets" value="<?=$product['amoName']?>"> 
                  <input type="hidden" name="sum" value="<?=$product['amoPrice']?>" data-type="number"> 
                  <input type="hidden" name="need-email" value="true"> 
                  <input type="submit" value="Оплатить <?=$product['amoPrice'];?> р."> 
              </form> -->

              <!--  <a target="_blank" href="http://polza.com/app/api/payment/fondy/control/pay.php?price=<?=$product['amoPrice']?>&order=<?=$lead['id']?>&currency=RUB&order_desc=<?=$product['amoName']?>"><h3 class="text-center">Оплатить <?=$product['amoPrice'];?> р.</h3></a> -->
               
            </div>
          </div>
          <div class="row" id="secure">
            <div class="col-md-4 text-center">
              <img class="grayscale" src="http://vizi.net.ua/custom_css/images/verified-by-visa.png">
            </div>
            <div class="col-md-4 text-center">
              <img class="grayscale" src="http://www.mmbank.by/uploads/userfiles/images/mc_seccode_png.png">
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