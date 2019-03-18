<?php

  include( $_SERVER['DOCUMENT_ROOT'].'/app/api/class.php');
  $api = new API();
  $api->connect();

  $id = $_GET['id'];
  $lead = $api->query(" SELECT * FROM `app_leads` WHERE `id` = '$id' LIMIT 1 ");

  $contact_id = $lead['contact'];
  $contact = $api->query(" SELECT * FROM `app_contact` WHERE `id` = '$contact_id' LIMIT 1 ");

  $product_id = $lead['product'];
  $product = $api->query(" SELECT * FROM `products` WHERE `id` = '$product_id' LIMIT 1 ");

  $name = $_GET['name'];
  $phone = $_GET['phone'];
  $email = $_GET['email'];

  if ($product['price']=='0') {
    
    $priceCheck = round($product['amoPrice']/56.7);
    $priceCheckUAH = round($product['amoPrice']/2.1);

    $priceUSD = $priceCheck;
    $priceRUB = $product['amoPrice'];
    $priceUAH = $priceCheckUAH;

    $sign_uah = $priceCheckUAH.'|'.$lead['id'].'|UAH|'.$product['amoName'].'|fuckyou';
    $sign_uah = md5($sign_uah);
    $url_pay_uah = 'http://polza.com/app/core/fondy/pay.php?price='.$priceCheckUAH.'&order='.$lead['id'].'&currency=UAH&order_desc='.$product['amoName'].'&sign='.$sign_uah;
    
    $sign_rub = $product['amoPrice'].'|'.$lead['id'].'|RUB|'.$product['amoName'].'|fuckyou';
    $sign_rub = md5($sign_rub);
    $url_pay_rub = 'http://polza.com/app/core/pay2me/pay.php?price='.$product['amoPrice'].'&order='.$lead['id'].'&currency=RUB&order_desc='.$product['amoName'].'&sign='.$sign_rub;

    $sign_usd = $priceCheck.'|'.$lead['id'].'|USD|'.$product['amoName'].'|fuckyou';
    $sign_usd = md5($sign_usd);
    $url_pay_usd = 'http://polza.com/app/core/fondy/pay.php?price='.$priceCheck.'&order='.$lead['id'].'&currency=USD&order_desc='.$product['amoName'].'&sign='.$sign_usd;
  }
  else{

    $rates = file_get_contents('http://polza.com/app/core/memory/rates.json');
    $rates = json_decode($rates, true);

    $priceUSD = $product['price'];
    $priceRUB = round($priceUSD*$rates['RUB']);
    $priceUAH = round($priceUSD*$rates['UAH']);

    $sign_uah = $priceUAH.'|'.$lead['id'].'|UAH|'.$product['amoName'].'|fuckyou';
    $sign_uah = md5($sign_uah);
    $url_pay_uah = 'http://polza.com/app/core/fondy/pay.php?price='.$priceUAH.'&order='.$lead['id'].'&currency=UAH&order_desc='.$product['amoName'].'&sign='.$sign_uah;
    
    $sign_rub = $priceRUB.'|'.$lead['id'].'|RUB|'.$product['amoName'].'|fuckyou';
    $sign_rub = md5($sign_rub);
    $url_pay_rub = 'http://polza.com/app/core/pay2me/pay.php?price='.$priceRUB.'&order='.$lead['id'].'&currency=RUB&order_desc='.$product['amoName'].'&sign='.$sign_rub;

    $sign_usd = $priceUSD.'|'.$lead['id'].'|USD|'.$product['amoName'].'|fuckyou';
    $sign_usd = md5($sign_usd);
    $url_pay_usd = 'http://polza.com/app/core/fondy/pay.php?price='.$priceUSD.'&order='.$lead['id'].'&currency=USD&order_desc='.$product['amoName'].'&sign='.$sign_usd;
  }

  
  
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
               <a target="_blank" href="<?=$url_pay_usd;?>"><h3 class="text-center">Оплатить <?=$priceUSD;?> $</h3></a>
               <a target="_blank" href="<?=$url_pay_uah;?>"><h3 class="text-center">Оплатить <?=$priceUAH;?> грн.</h3></a>
               <a target="_blank" href="<?=$url_pay_rub;?>"><h3 class="text-center">Оплатить <?=$priceRUB;?> р.</h3></a>
            </div>
          </div>
          <div class="row" id="secure">
            <div class="col-md-4 text-center">
              <img class="grayscale" src="img/visa.png">
            </div>
            <div class="col-md-4 text-center">
              <img class="grayscale" src="img/mastercard.png">
            </div>
            <div class="col-md-4 text-center">
              <img class="grayscale" src="img/pci.png">
            </div>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center fs-12 pb-20">
        © polza.com Все права защищены. <a target="_blank" href="http://pages.polza.com/publichnyiy-dogovor">Публичный договор</a>.<br>
        По всем вопросам: zabota@polza.com, +7 499 753 34 43, +7 771 72 72 39
      </div>
    </div>
  </body>
</html>