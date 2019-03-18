<?

$form_phone = '380933843132';
$sms_url = 'https://smsc.ru/sys/send.php?login=polzacom&psw=polzacom1&phones='.$form_phone.'&hlr=1';


echo file_get_contents($sms_url);

?>