<?php


  if(!empty($_GET['id'])){

    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/pay/page_full.php');

  }elseif( !empty($_GET['product']) && !empty($_GET['email']) ){

    include( $_SERVER['DOCUMENT_ROOT'].'/app/api/pay/page_form.php');

  }else{

  }

  
?>