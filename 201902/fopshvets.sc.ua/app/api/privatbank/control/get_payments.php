<?

// Отображение ошибок (1 – показывать, 0 – скрывать)
// ini_set('display_errors', 1);

$id = $_GET['id'];
$pass = $_GET['pass'];
$card = $_GET['card'];

// $card = '5169330508353031';
// $id = '120242';
// $pass = 'd163CE6Vr9zQ09v7gzn1G9Mi698n95Yd';

$start_date = date("d.m.Y",mktime(0, 0, 0, date("m")-2  , date("d"), date("Y")));
$end_date = date("d.m.Y");

// $start_date = '28.02.2017';
// $end_date = '31.03.2017';

$data = '<oper>cmt</oper>
                    <wait>0</wait>
                    <test>0</test>
                    <payment id="">
                        <prop name="sd" value="'.$start_date.'" />
                        <prop name="ed" value="'.$end_date.'" />
                        <prop name="card" value="'.$card.'" />
                    </payment>';

$sign=sha1(md5($data.$pass));

$input_xml = '<?xml version="1.0" encoding="UTF-8"?>
<request version="1.0">
  <merchant>
    <id>'.$id.'</id>
    <signature>'.$sign.'</signature>
  </merchant>
  <data>
    <oper>cmt</oper>
    <wait>0</wait>
    <test>0</test>
    <payment id="">
      <prop name="cardnum" value="'.$card.'" />
      <prop name="country" value="UA" />
    </payment>
  </data>
</request>';

$input_xml = '<?xml version="1.0" encoding="UTF-8"?>
            <request version="1.0">
                <merchant>
                    <id>'.$id.'</id>
                    <signature>'.$sign.'</signature>
                </merchant>
                <data>
                    <oper>cmt</oper>
                    <wait>0</wait>
                    <test>0</test>
                    <payment id="">
                        <prop name="sd" value="'.$start_date.'" />
                        <prop name="ed" value="'.$end_date.'" />
                        <prop name="card" value="'.$card.'" />
                    </payment>
                </data>
            </request>';


$url = "https://api.privatbank.ua/p24api/rest_fiz";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
$data = curl_exec($ch);

curl_close($ch);


$array_data = json_decode(json_encode(simplexml_load_string($data)), true);

echo '<pre>';
print_r($array_data);

// foreach ($array_data['data']['info']['statements']['statement'] as $key => $value) {
     
//      if (!empty($array)) {
//          array_push($array, array(
//              'card' => $value['@attributes']['card'], 
//              'trandate' => $value['@attributes']['trandate'], 
//              'trantime' => $value['@attributes']['trantime'], 
//              'amount' => $value['@attributes']['cardamount'],
//              'terminal' => $value['@attributes']['terminal'],
//              'description' => $value['@attributes']['description']
//              ) 
//          );
//      } else {
//      $array = array(
//          array(
//              'card' => $value['@attributes']['card'], 
//              'trandate' => $value['@attributes']['trandate'], 
//              'trantime' => $value['@attributes']['trantime'], 
//              'amount' => $value['@attributes']['cardamount'],
//              'terminal' => $value['@attributes']['terminal'],
//              'description' => $value['@attributes']['description']
//              )
//          );
//      }
//  }

// echo json_encode(array($array);


 // $json_data = array();

 // echo json_encode($json_data);

 // $n = 0;
 foreach ($array as $key => $value) {

    // if (strpos($value['amount'], '-') !== false){
        
    // }else{
        echo '<tr><td class="date">'.$value['trandate'].' '.$value['trantime'].'</td><td class="amount">'.$value['amount'].'</td><td class="terminal">'.$value['description'].'</td></tr>';
    // }

 }

// $bot_text = 'privatbank payments';
// $bot->say_test($bot_text);

?>