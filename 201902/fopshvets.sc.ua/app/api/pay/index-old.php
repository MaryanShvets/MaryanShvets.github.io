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
   
?>

  <head>
    <META NAME="ROBOTS" CONTENT="NOINDEX">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="styla.css">
    <title>Оплата</title>
    <!-- Google Tag Manager -->
    <script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','GTM-5R5D4Q');
    </script>
  </head>

  <body style="display: none;">
    <div class="container">
      <div class="row">
        <!--  <div class="col-md-10 col-md-offset-1">
      <h2>Выставлен счет №<?= $_GET['i']?> на сумму <?= $_GET['price']?>.00 грн. за продукт "Путь Женщины"</h2>
    </div> -->

        <div class="col-md-10 col-md-offset-1">
          <h2 style="
    margin: 1em auto;
    width: 640px;
    /* font-weight: bold; */
    /* font-weight: 100; */
    margin-bottom: 0;
    text-align: center;
    margin-top: 70px;
    font-weight: 100;
    font-size: 28px;
"><strong class="price" style="font-weight: 400;"><?= $product['amoPrice']?> руб</strong></h2>
          <h3 style="
    margin: 1em auto;
    width: 640px;
    font-size: 22px;
    margin-top: 0;
    color: grey;
    text-align: center;
    margin-bottom: 60px;
">Cчет № <?= $id;?></h3>
        </div>
      </div>
    </div>

    <div id="choose">Выберите способ оплаты</div>

    <div id='tabs'>
      <ul>
        <li>
          <a href='#tabs-1'>
            <svg viewBox="0 0 40 38" xmlns="http://www.w3.org/2000/svg"><title>card-horiz-radio copy 3</title><defs><linearGradient x1="-233.561%" y1="45.081%" x2="372.942%" y2="44.569%" id="a"><stop stop-color="#191E5F" offset="0%"/><stop stop-color="#142787" stop-opacity=".818" offset="100%"/></linearGradient><linearGradient x1="-182.481%" y1="35.379%" x2="225.539%" y2="33.408%" id="b"><stop stop-color="#191E5F" offset="0%"/><stop stop-color="#142787" stop-opacity=".818" offset="100%"/></linearGradient><linearGradient x1="-228.811%" y1="26.836%" x2="110.695%" y2="23.739%" id="c"><stop stop-color="#191E5F" offset="0%"/><stop stop-color="#142787" stop-opacity=".818" offset="100%"/></linearGradient><linearGradient x1="-13.859%" y1="26.721%" x2="265.571%" y2="24.298%" id="d"><stop stop-color="#191E5F" offset="0%"/><stop stop-color="#142787" stop-opacity=".818" offset="100%"/></linearGradient><linearGradient x1="32.506%" y1="47.883%" x2="294.087%" y2="43.303%" id="e"><stop stop-color="#191E5F" offset="0%"/><stop stop-color="#142787" stop-opacity=".818" offset="100%"/></linearGradient><linearGradient x1="-156.382%" y1="335.864%" x2="3998.32%" y2="267.357%" id="f"><stop stop-color="#191E5F" offset="0%"/><stop stop-color="#142787" stop-opacity=".818" offset="100%"/></linearGradient></defs><g fill="none" fill-rule="evenodd"><path d="M16.095.13h3.236l-2.024 11.604h-3.235L16.095.13z" fill="url(#a)" transform="translate(0 25.333)"/><path d="M29.06.506a8.531 8.531 0 0 0-2.9-.487c-3.198 0-5.45 1.574-5.47 3.829-.018 1.667 1.608 2.597 2.836 3.152 1.26.569 1.683.932 1.677 1.44-.008.777-1.006 1.133-1.936 1.133-1.296 0-1.984-.176-3.047-.61l-.417-.184-.454 2.598c.756.324 2.154.604 3.605.619 3.402 0 5.61-1.556 5.635-3.964.012-1.32-.85-2.325-2.717-3.153-1.131-.537-1.824-.895-1.816-1.438 0-.483.586-.998 1.853-.998a6.09 6.09 0 0 1 2.422.444l.29.134.439-2.515" fill="url(#b)" transform="translate(0 25.333)"/><path d="M37.358.232h-2.5c-.775 0-1.355.206-1.695.962l-4.806 10.633h3.398s.555-1.43.681-1.743l4.145.005c.096.406.393 1.738.393 1.738h3.003L37.357.232zm-3.99 7.478c.267-.668 1.289-3.243 1.289-3.243-.02.03.265-.672.429-1.108l.219 1 .749 3.351h-2.687z" fill="url(#c)" transform="translate(0 25.333)"/><path d="M11.367.032L8.199 7.945 7.86 6.337c-.59-1.854-2.427-3.862-4.482-4.868l2.897 10.148 3.424-.004L14.795.033h-3.428" fill="url(#d)" transform="translate(.007 25.53)"/><path d="M5.26.025H.04L0 .267c4.06.96 6.746 3.281 7.861 6.07L6.726 1.005C6.53.27 5.962.05 5.26.025" fill="url(#e)" transform="translate(.007 25.53)"/><path d="M3.514 2.107c-.067-.243-.137-.389-.393-.524l.954.42" fill="url(#f)" transform="translate(0 25.333)"/><g><path d="M37.146 10c.002 5.421-4.413 9.817-9.861 9.818-5.448.001-9.865-4.392-9.866-9.813V10c-.002-5.421 4.413-9.817 9.86-9.818 5.449-.002 9.866 4.392 9.867 9.813V10z" fill="#F90"/><path d="M13.987.184C8.572.22 4.187 4.603 4.187 10c0 5.418 4.419 9.815 9.864 9.815 2.555 0 4.885-.969 6.637-2.557h.002a9.928 9.928 0 0 0 1.001-1.052h-2.02a9.588 9.588 0 0 1-.736-1.01h3.485c.212-.338.404-.689.574-1.052H18.36a9.653 9.653 0 0 1-.412-1.03h5.46a9.79 9.79 0 0 0 .28-5.215l-6.03-.001c.075-.349.17-.693.282-1.031h5.462a9.79 9.79 0 0 0-.425-1.051h-4.617c.166-.354.355-.699.566-1.031h3.483a9.839 9.839 0 0 0-.766-1.051H19.7c.3-.352.631-.683.99-.992A9.856 9.856 0 0 0 14.05.184h-.063z" fill="#C00"/><g fill="#FFF"><path d="M6.135 12.554l.64-3.752.093 3.752h.724l1.35-3.752-.598 3.752h1.075l.828-4.977H8.584L7.55 10.631l-.054-3.054H5.962l-.84 4.977h1.013zm5.687-4.144c-.72 0-1.273.23-1.273.23l-.152.9s.456-.184 1.144-.184c.391 0 .678.044.678.36 0 .192-.036.263-.036.263s-.308-.026-.45-.026c-.91 0-1.863.386-1.863 1.549 0 .916.626 1.127 1.014 1.127.74 0 1.06-.479 1.077-.48l-.035.399h.925l.413-2.878c0-1.221-1.07-1.26-1.442-1.26zm.225 2.343c.02.176-.111 1-.744 1-.326 0-.41-.248-.41-.395 0-.286.156-.63.925-.63.18.001.198.02.229.025zm2.2 1.855c.236 0 1.589.06 1.589-1.33 0-1.297-1.252-1.041-1.252-1.563 0-.26.204-.341.577-.341.148 0 .717.047.717.047l.133-.923s-.369-.082-.97-.082c-.776 0-1.565.309-1.565 1.365 0 1.196 1.315 1.076 1.315 1.58 0 .336-.367.364-.65.364-.49 0-.931-.167-.933-.16l-.14.914c.026.008.298.129 1.179.129zm3.35-.109l.132-.888c-.071 0-.177.03-.27.03-.366 0-.406-.193-.383-.336l.295-1.813h.556l.134-.982h-.524l.107-.611h-1.05c-.023.023-.62 3.436-.62 3.852 0 .615.347.89.837.885.383-.003.682-.109.787-.137zm13.537.062c.306-1.73.362-3.135 1.092-2.878.127-.67.25-.928.39-1.212 0 0-.065-.013-.202-.013-.47 0-.82.64-.82.64l.094-.588h-.977l-.656 4.05h1.079zm5.019-.625a.323.323 0 0 1 .275.158.318.318 0 1 1-.275-.158zm0 .052a.271.271 0 0 0-.23.133.266.266 0 0 0-.002.264.271.271 0 0 0 .364.098.266.266 0 0 0-.002-.46.27.27 0 0 0-.13-.035zm-.14.44v-.34h.118c.04 0 .07.002.087.009a.084.084 0 0 1 .044.033.09.09 0 0 1-.01.115.104.104 0 0 1-.072.03.105.105 0 0 1 .029.019c.014.013.03.036.05.068l.043.066h-.068l-.03-.053a.277.277 0 0 0-.058-.08.071.071 0 0 0-.045-.012h-.032v.146h-.056zm.055-.178h.079c.037 0 .063-.005.076-.016a.052.052 0 0 0 .02-.043.05.05 0 0 0-.009-.03.06.06 0 0 0-.027-.021.21.21 0 0 0-.065-.007h-.074v.117zm-7.222-3.84c-.72 0-1.272.23-1.272.23l-.152.9s.455-.184 1.144-.184c.391 0 .677.044.677.36 0 .192-.035.263-.035.263s-.308-.026-.451-.026c-.908 0-1.862.386-1.862 1.549 0 .916.625 1.127 1.013 1.127.741 0 1.06-.479 1.078-.48l-.035.399h.925l.413-2.878c0-1.221-1.07-1.26-1.443-1.26zm.226 2.343c.02.176-.111 1-.744 1-.326 0-.41-.248-.41-.395 0-.286.156-.63.925-.63.18.001.198.02.229.025zm-6.756 1.808c.306-1.73.363-3.135 1.092-2.878.128-.67.251-.928.39-1.212 0 0-.065-.013-.202-.013-.47 0-.819.64-.819.64l.094-.588h-.978l-.655 4.05h1.078zm12.807-4.98l-.227 1.4s-.395-.544-1.014-.544c-.963 0-1.765 1.154-1.765 2.481 0 .856.428 1.695 1.303 1.695.629 0 .978-.436.978-.436l-.047.373h1.022l.802-4.97-1.052.001zm-.488 2.728c0 .552-.275 1.29-.844 1.29-.378 0-.555-.317-.555-.812 0-.81.365-1.345.827-1.345.378 0 .572.258.572.867zm-8.212 2.19l.188-1.14s-.515.257-.87.257c-.744 0-1.043-.566-1.043-1.174 0-1.234.641-1.912 1.355-1.912.535 0 .964.299.964.299l.172-1.107s-.637-.257-1.183-.257c-1.212 0-2.392 1.047-2.392 3.012 0 1.304.637 2.165 1.89 2.165.355 0 .919-.143.919-.143zm-8.492-1.694c0 1.477.98 1.828 1.814 1.828.77 0 1.11-.171 1.11-.171l.184-1.008s-.586.257-1.115.257c-1.128 0-.93-.837-.93-.837h2.134s.138-.677.138-.953c0-.689-.345-1.528-1.498-1.528-1.056 0-1.837 1.133-1.837 2.412zm1.841-1.476c.593 0 .484.663.484.717H19.09c0-.069.11-.717.682-.717z"/></g></g></g></svg>
            <p class="plat">Оплата картой</p>
          </a>
        </li>
        <li>
          <a href='#tabs-2'>
            <svg viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><g id="v.4.6-(exp)" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><g id="ym_logo_20x20" sketch:type="MSArtboardGroup"><g id="yandex.dengi_product-icon_rgb" sketch:type="MSLayerGroup" transform="translate(2.000000, 0.000000)"><g id="Group-3" fill="#F9C637" sketch:type="MSShapeGroup"><path d="M0.000226415094,9.95275986 C0.000226415094,8.83318996 0.0990943396,8.1227957 2.53992453,6.3921147 C4.56075472,4.95935484 11.0379623,0.0631541219 11.0379623,0.0631541219 L11.0379623,8.23648746 L15.9638491,8.23648746 L15.9638491,20 L1.53879245,20 C0.692603774,20 0,19.3420789 0,18.5383513 L0.000226415094,9.95275986" id="Fill-1"></path></g><path d="M11.0379623,8.23648746 L11.0379623,12.9724014 L1.98649057,18.8292473 L13.430566,15.2925448 L13.430566,8.23648746 L11.0379623,8.23648746" id="Fill-4" fill="#C8A332" sketch:type="MSShapeGroup"></path><path d="M6.90173585,7.99154122 C7.43101887,7.39247312 8.204,7.1809319 8.6285283,7.51928315 C9.05298113,7.85763441 8.96815094,8.61770609 8.43879245,9.21670251 C7.90973585,9.81569892 7.1365283,10.0269534 6.712,9.68860215 C6.28754717,9.35032258 6.37260377,8.59053763 6.90173585,7.99154122" id="Fill-5" fill="#000106" sketch:type="MSShapeGroup"></path></g></g></g></svg>
            <p class="plat">Электронные деньги</p>
          </a>
        </li>
        <li>
          <a href='#tabs-3'>
            <img class="icon icons8-Запрос-денег" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAADbElEQVRoQ+2Z8XUNURDGv1eBqAAVoAJUgApQASogFYQKUAEqIBUkKkAFqCA5v3PuOJO1u3fm7t7zkvfMP8mRu3vnm/lm5pu10Y7YZkdwaC+AnF2hbG3mMrJzQC4z/SzYFzJylTIA6wnwfgAxKv2SdCDppaQ3Wyr8F5KOJP2QdKv48DcLtYxcl/Rc0mtJ3yTdSYLg/BNJ992zp5K+Svogid8zBogbxZ+3kghwiFq/SyY4/FjSp+CtZI/oPa2cf1+yzD0ReyTpYznofQvVyHGhUwbEl5KBP5JwlmfJAkZ2cIhMY2TlgaQMGGh2zyGvAuECcyASMc6cFBBQEYehw5jdLABvFzB3oxe4gBCwELWyc4NaeiXpZwFTizIUJCPw/rBwP4MnXOwZIDj1vdRUJpNQjcgCmm5UA++BdgFCYb+TRE3hXMagL5x/Vmoq+mwXIBT0wwZncNqC8LnUVVcgUIeIU8A4TfQ8DaAVBQw9pgp8ykHmDU2CevFFX7uzKSPw2FNmGD3/0mhEp/hu/565c1Zr+WK3gxSyb3t2aQ8gmTvDQKwgzfFhRkw+LKHWUAbV7myiFnxlSlPQgKBAfY30KPbanU1Aary3zkMUoV/GrBYuRfsletDrWgESlTY2ENFldL2tD0QyYBIFQLTRmlOAp+0CoKtEyUgNoxKzwIQg0n9ONCLJmSEtasAyGRKNHIIiLDEZGc8zgMHYKHkWZzGkCEMVKY7RqXCqlj0LlK0AfqZVZTy8hfNYdrECANvhnLElAigDwhYr75u/Y/QrCqsuFyHNh/Ih0pWgDd2Mn7YIkRneRSvPrromg6gnAmWrbhWITXYbdtn2GAEbPWMfH9h1aA7YqJoYkyPRS7Z97sLetJNA1orwlJBcKjBn/custVGg/4FEIzV2bu8zgl7ykzwSpLmv/dlJ/899SzJSAzN89xSQxSBAtQQIz3sZz9RmeEaMDxpM/xYZP/r+pUB4KVIEmqHPImA8CERgVrJ0A2Jg2DGwOUljkoNz7C6rgFiDWj46tvZOgan9PULJyTNrUGsKjF/Q/ELURYSuDQRQ1Ak7CfuGfZDgQwONgWXNlqtFGRg+3APIEIx1Nxaq2v9mNYPrBQSH/Ie2lv08BaonEBuYOJTZz1MA7HBPIEYpfkb38yYQa7ffZifWeLB3RtbwMfSOc8pZBEJshmbgAAAAAElFTkSuQmCC">
            <p class="plat">Денежные переводы</p>
          </a>
        </li>
      </ul>

      <section class='tabs-content'>
        <article id='tabs-1'>
          <div id="Liqpay" style="display: none;" class="card">
            <div class="block_info">
              <p><span class="info">Имя:</span>
                <?= $contact['name']?>
              </p>
              <p><span class="info">Почта:</span>
                <?= $contact['email']?>
              </p>
              <p><span class="info">Телефон:</span>
                <?= $contact['phone']?>
              </p>
              <p><span class="info">Способ оплаты:</span> VISA/MasterCard Fondy (Украина)</p>
            </div>
            <form name="order_form_57" action="http://samoylov.e-autopay.com/checkout/save_order_data.php" method="post" target="_blank" accept-charset="windows-1251">
              <input type="hidden" name="name" value="<?= $_GET['name']?>" style="width: 360px;">
              <input type="hidden" name="email" value="<?= $_GET['email']?>" style="width: 360px;">
              <input type="hidden" name="phone" class="ea_phone ea_input" value="<?= $_GET['phone']?>">
              <input type="hidden" name="additional_field1" id="additional_field1" value="<?= $_GET['i']?>">
              <input type="hidden" name="additional_field2" id="additional_field2">
              <input type="hidden" name="pay_mode" value="24">
              <a class="button" style="background: rgb(122, 183, 43);color: white;border: 0;padding: 10px 50px;font-size: 25px;text-transform: uppercase;border-radius: 50px;position: absolute;margin-top: 18px;width: 640px;margin-left: -16px;text-align: center;border-radius: 0px;" href="http://polza.com/app/api/payment/fondy/control/pay.php?price=<?=$product['amoPrice'];?>&currency=UAH&order=<?=$id;?>&order_desc=polza.com">Оплатить</a>
              
          </div>
          <div id="Fondy" style="display: none;" class="card">
            <div class="block_info">
              <p><span class="info">Имя:</span>
                <?= $contact['name']?>
              </p>
              <p><span class="info">Почта:</span>
                <?= $contact['email']?>
              </p>
              <p><span class="info">Телефон:</span>
                <?= $contact['phone']?>
              </p>
              <p><span class="info">Способ оплаты:</span> VISA/MasterCard </p>
            </div>
            <form name="order_form_57" action="http://samoylov.e-autopay.com/checkout/save_order_data.php" method="post" target="_blank" accept-charset="windows-1251">
              <input type="hidden" name="name" value="<?= $_GET['name']?>" style="width: 360px;">
              <input type="hidden" name="email" value="<?= $_GET['email']?>" style="width: 360px;">
              <input type="hidden" name="phone" class="ea_phone ea_input" value="<?= $_GET['phone']?>">
              <input type="hidden" name="additional_field1" id="additional_field1" value="<?= $_GET['i']?>">
              <input type="hidden" name="additional_field2" id="additional_field2">
              <input type="hidden" name="pay_mode" value="24">
              <?
          if ($_GET['e'] == '275575') {?>
                <input type="hidden" name="any_price" value="<?= $_GET['price']/61?>">
                <?} else {?>
                  <input type="hidden" name="any_price" value="<?= $_GET['price']/61?>">
                  <?}?>
                    <input type="hidden" name="tovar_id" value="<?= $_GET['e']?>">
                    <input type="hidden" name="form_id" value="18776">
                    <input type="hidden" name="city" value="">
                    <input class="button" style="background: rgb(122, 183, 43);color: white;border: 0;padding: 10px 50px;font-size: 25px;text-transform: uppercase;border-radius: 50px;position: absolute;margin-top: 18px;width: 640px;margin-left: -16px;text-align: center;border-radius: 0px;"
                      type="submit" value="Оплатить">
            </form>
          </div>
          <div id="WalletOne" style="display: none;" class="card">
            <div class="block_info">
              <p><span class="info">Имя:</span>
                <?= $contact['name']?>
              </p>
              <p><span class="info">Почта:</span>
                <?= $contact['email']?>
              </p>
              <p><span class="info">Телефон:</span>
                <?= $contact['phone']?>
              </p>
              <p><span class="info">Способ оплаты:</span> VISA/MasterCard WalletOne (Россия)</p>
            </div>
            <form name="order_form_57" action="http://samoylov.e-autopay.com/checkout/save_order_data.php" method="post" target="_blank" accept-charset="windows-1251">
              <input type="hidden" name="name" value="<?= $_GET['name']?>" style="width: 360px;">
              <input type="hidden" name="email" value="<?= $_GET['email']?>" style="width: 360px;">
              <input type="hidden" name="phone" class="ea_phone ea_input" value="<?= $_GET['phone']?>">
              <input type="hidden" name="additional_field1" id="additional_field1" value="<?= $_GET['i']?>">
              <input type="hidden" name="additional_field2" id="additional_field2">
              <input type="hidden" name="pay_mode" value="20">
              <?
          if ($_GET['e'] == '275575') {?>
                <input type="hidden" name="any_price" value="<?= $_GET['price']/61?>">
                <?} else {?>
                  <input type="hidden" name="any_price" value="<?= $_GET['price']/61?>">
                  <?}?>
                    <input type="hidden" name="tovar_id" value="<?= $_GET['e']?>">
                    <input type="hidden" name="form_id" value="18776">
                    <input type="hidden" name="city" value="">
                    <input class="button" style="background: rgb(122, 183, 43);color: white;border: 0;padding: 10px 50px;font-size: 25px;text-transform: uppercase;border-radius: 50px;position: absolute;margin-top: 18px;width: 640px;margin-left: -16px;text-align: center;border-radius: 0px;"
                      type="submit" value="Оплатить">
            </form>
          </div>

          <div class="icon-pay" style="display: none;">
            <a href="#Liqpay" class="title-card Liqpay">Liqpay</a>
            <a href="#Fondy" class="title-card Fondy">Fondy</a>
            <a href="#WalletOne" class="title-card WalletOne">Wallet One</a>
          </div>
        </article>
        <article id='tabs-2'>
          <div id="yandex" class="in MoneyGram electro">
            <div class="block_info">
              <p><span class="info">Имя:</span>
                <?= $contact['name']?>
              </p>
              <p><span class="info">Почта:</span>
                <?= $contact['email']?>
              </p>
              <p><span class="info">Телефон:</span>
                <?= $contact['phone']?>
              </p>
              <p><span class="info">Способ оплаты:</span> Электронные деньги, Яндекс.Деньги</p>
            </div>
            <form name="order_form_57" action="http://samoylov.e-autopay.com/checkout/save_order_data.php" method="post" target="_blank" accept-charset="windows-1251">
              <input type="hidden" name="name" value="<?= $_GET['name']?>" style="width: 360px;">
              <input type="hidden" name="email" value="<?= $_GET['email']?>" style="width: 360px;">
              <input type="hidden" name="phone" class="ea_phone ea_input" value="<?= $_GET['phone']?>">
              <input type="hidden" name="additional_field1" id="additional_field1" value="<?= $_GET['i']?>">
              <input type="hidden" name="additional_field2" id="additional_field2">
              <input type="hidden" name="pay_mode" value="15">
              <?
          if ($_GET['e'] == '275575') {?>
                <input type="hidden" name="any_price" value="<?= $_GET['price']/61?>">
                <?} else {?>
                  <input type="hidden" name="any_price" value="<?= $_GET['price']/61?>">
                  <?}?>
                    <input type="hidden" name="tovar_id" value="<?= $_GET['e']?>">
                    <input type="hidden" name="form_id" value="18776">
                    <input type="hidden" name="city" value="">
                    <input class="button" style="background: rgb(122, 183, 43);color: white;border: 0;padding: 10px 50px;font-size: 25px;text-transform: uppercase;border-radius: 50px;position: absolute;margin-top: 18px;width: 640px;margin-left: -16px;text-align: center;border-radius: 0px;"
                      type="submit" value="Оплатить">
            </form>
          </div>
          <div id="webmoney" class="in webmoney electro" style="display: none;">
            <div class="block_info">
              <p><span class="info">Имя:</span>
                <?= $contact['name']?>
              </p>
              <p><span class="info">Почта:</span>
                <?= $contact['email']?>
              </p>
              <p><span class="info">Телефон:</span>
                <?= $contact['phone']?>
              </p>
              <p><span class="info">Способ оплаты:</span> Электронные деньги, WebMoney</p>
            </div>
            <div class="block_info">

              <strong>Платёжная система WebMoney:</strong><br>

              <span class="info">WMU:</span> U786556808799<br>
              <span class="info">WMR:</span> R160199814924<br>
              <span class="info">WMZ:</span> Z351074481569</div>
          </div>
          <div id="qiwi" class="in qiwi electro" style="display: none;">
            <div class="block_info">
              <p><span class="info">Имя:</span>
                <?= $contact['name']?>
              </p>
              <p><span class="info">Почта:</span>
                <?= $contact['email']?>
              </p>
              <p><span class="info">Телефон:</span>
                <?= $contact['phone']?>
              </p>
              <p><span class="info">Способ оплаты:</span> Электронные деньги, QIWI</p>
            </div>
            <div class="block_info">
              <strong>Платежная система QIWI:</strong><br>
              <p><span class="info">Номер кошелька:</span> +380939187782</p>
            </div>
          </div>
          <div class="icon-pay">
            <a href="#yandex" class="title-electro active yandex">Яндекс.Деньги</a>
            <a href="#webmoney" class="title-electro webmoney">WebMoney</a>
            <a href="#qiwi" class="title-electro qiwi">QIWI</a>
          </div>
        </article>
        <article id='tabs-3'>


          <div id="Westernunion" class="in Westernunion transin">
            <div class="block_info">
              <p><span class="info">Имя:</span>
                <?= $contact['name']?>
              </p>
              <p><span class="info">Почта:</span>
                <?= $contact['email']?>
              </p>
              <p><span class="info">Телефон:</span>
                <?= $contact['phone']?>
              </p>
              <p><span class="info">Способ оплаты:</span> Денежный перевод Western Union</p>
            </div>
            <a id="ajax" class="ajax" onclick="return false" href="http://app.polza.com/lead/pay_translation?id=<?= $_GET['i']?>&i=0" style="background: rgb(122, 183, 43);color: white;border: 0;padding: 10px 50px;font-size: 25px;text-transform: uppercase;border-radius: 50px;position: absolute;margin-top: 18px;width: 640px;margin-left: -16px;text-align: center;border-radius: 0px;">Оплатить</a>
            <h5 class="result" style="display: none">Отлично, мы с вами свяжемся и уточним детали</h5>
          </div>

          <div class="icon-pay">
            <!-- <a href="#MoneyGram" class="title MoneyGram">MoneyGram</a> -->
            <a href="#Westernunion" class="title active Westernunion">Western Union</a>
          </div>
        </article>
      </section>
      <a id="binotel" onclick="clik()" href="#">Нужна помощь?</a>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src='http://code.jquery.com/ui/1.11.2/jquery-ui.js'></script>
    <script>
      $('#tabs ul li a').click(function(){
        $("section").animate({opacity: 0}, 0);
        $("section").animate({opacity: 1}, 500);
      });
      $(function() {
        $("#tabs").tabs();
      });
      
      $(document).ready(function() {
        $("a.title").click(function(e) {
          e.preventDefault();
          $("a.title").removeClass("active");
          $(this).addClass("active");
          var href = $(this).attr('href');
          $(".transin").fadeOut(0);
          $(href).fadeIn(100);
          console.log(href);
        });
        $("a.title-card").click(function(e) {
          e.preventDefault();
          $("a.title-card").removeClass("active");
          $(this).addClass("active");
          var href = $(this).attr('href');
          $("div.card").fadeOut(0);
          $(href).fadeIn(100);
          console.log(href);
        });
        $("a.title-electro").click(function(e) {
          e.preventDefault();
          $("a.title-electro").removeClass("active");
          $(this).addClass("active");
          var href = $(this).attr('href');
          $("div.electro").fadeOut(0);
          $(href).fadeIn(100);
          console.log(href);
        });
      });
      
      $(".ajax").click(function(e) {
        var href = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: href,
            success: function(data)
            {
              // alert(data);
              console.log(this);
              $('#tabs').fadeOut(500);
              $('.col-md-10.col-md-offset-1').animate({opacity: 0}, 1000);
              $('#choose').text('Отлично, мы с вами свяжемся и уточним детали');
              $('.result').fadeIn(500);
            }
        });
        e.preventDefault();
      });
      function addScript(src){
        var script = document.createElement('script');
        script.src = src;
        script.async = false; // чтобы гарантировать порядок
        document.head.appendChild(script);
      }
      // подгружаем скрипт
      addScript('http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU');
      
      window.onload = function () {
        var city = ymaps.geolocation.city;
        $('.city span').text(city);
      
        var country = ymaps.geolocation.country;
        $('.geo span').text(country);
        $('input[name=city]').val(country+', г.'+city);
      
      
      
      // задайом курс
      var rep = /[a-zA-Zа-яА-Я]/,
      hostip = [],
      price = [],
      price1 = [],
      curs = {  
          rub: 59,
          ukr: 0.46
      },
      $price = $(".price"),
      $price1 = $(".price1"),
      len = $price.length,
      len1 = $price1.length,
      result;
      // проверяем по локации через яндекс
       
        var city = ymaps.geolocation.city;
        var country = ymaps.geolocation.country;
        if(country == 'Украина'){
            $('#Liqpay').fadeIn(0);
            $(".Liqpay").addClass("active");
            $('#privat').fadeIn(0);
            $(".privat").addClass("active");
            
            // jQuery("#user-city").text(country);
            for (var i = len - 1; i >= 0; i--) {
                // $('.price').fateIn(100);
                hostip[i] = $price.eq(i).text();
                price[i] = parseInt(hostip[i].replace(/\D+/g,""));
                result = price[i] * curs.ukr;
                $price.innerHTML = result; 
                $price.eq(i).text(Math.round(result) + ' грн');
                // console.log(i + ' - Цена:' + price[i] + ' Курс:' + curs.ukr + ' Сума:'+ result);
            }
            for (var i = len1 - 1; i >= 0; i--) {
                // $('.price').fateOut(100);
                hostip[i] = $price1.eq(i).text();
                price1[i] = parseInt(hostip[i].replace(/\D+/g,""));
                result = price1[i] * curs.ukr;
                $price1.innerHTML = result; 
                $price1.eq(i).text(Math.round(result) + ' грн');
                // console.log(i + ' - Цена:' + price1[i] + ' Курс:' + curs.ukr + ' Сума:'+ result);
            }
        }   
        else if(country == 'Россия' || country == 'Азербайджан' || country == 'Армения' || country == 'Белоруссия' || country == 'Казахстан' || country == 'Киргизия' || country == 'Молдавия' || country == 'Таджикистан' || country == 'Туркмения' || country == 'Узбекистан')
        {   
            $('#WalletOne').fadeIn(0);
            $(".WalletOne").addClass("active");
            $('#privat').fadeIn(0);
            $(".privat").addClass("active");
            // jQuery("#user-city").text('Доставка почтой России');
            for (var i = len - 1; i >= 0; i--) {
                hostip[i] = $price.eq(i).text();
                price[i] = parseInt(hostip[i].replace(/\D+/g,""));
                result = price[i];
                $price.innerHTML = result; 
                $price.eq(i).text(Math.round(result) + ' руб');
                // console.log(i + ' - Цена:' + price[i] + ' Курс:' + curs.rub + ' Сума:'+ result);
            }
            for (var i = len - 1; i >= 0; i--) {
                hostip[i] = $price1.eq(i).text();
                price1[i] = parseInt(hostip[i].replace(/\D+/g,""));
                result = price1[i];
                $price1.innerHTML = result; 
                $price1.eq(i).text(Math.round(result) + ' руб');
                // console.log(i + ' - Цена:' + price1[i] + ' Курс:' + curs.rub + ' Сума:'+ result);
            }
        } else {
          $('#Fondy').fadeIn(0);
          $(".Fondy").addClass("active");
        }
        $('body').fadeIn(1000);
      }
      $(".price1").css(
      {
          'text-decoration': 'line-through'
      })
    </script>
    <script type="text/javascript">
      (function(d, w, s) {
          var widgetHash = 'IXnlds0BiI', gcw = d.createElement(s); gcw.type = 'text/javascript'; gcw.async = true;
          gcw.src = '//widgets.binotel.com/getcall/widgets/'+ widgetHash +'.js';
          var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(gcw, sn);
       })(document, window, 'script');
      
        function clik() {
          var clik=document.getElementById("bingc-phone-button");
          clik.click();
        }
    </script>
    <style>
      #bingc-phone-button.bingc-show, .bingc-active {
        display: none !important;
      }
      #bingc-active.bingc-active-closed {
        display: none !important;
      }
      a#binotel {
        position: relative;
        top: 50px;
        width: 100%;
        text-align: center;
        display: block;
        color: #7ab72b;
      }
      @media (max-width: 640px) {
        #bingc-passive div.bingc-passive-overlay{
          width: 300px !important;
          top: 10px !important;
          height: 290px !important;
        }
      }
    </style>