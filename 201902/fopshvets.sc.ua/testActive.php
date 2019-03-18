<?php
$a= Array
(
    "phone" => 22220936888668,
	//"key"=>3752,
	//"secret"=>"glsfbgc",
	//"email"=>"innetiad5@gmail.com",
	//"first_name"=>"Serhii.Test3",
    "contact" => Array
        (
            "id" => 48131,
            "email" => "innetiad5@gmail.com",
            "first_name" => "Serhii.Test3",
            "last_name" => "",
            "phone" => 380936888668 ,
            "orgname" => "",
            "tags" => "test_test, fh_figure_go",
            "ip4" => "127.0.0.1",
            "fields" => Array
                (
                    "moneyplus1" => 12,
                    "open_email_status" => "||Active||",
                    "test_field" => "test_filed",
                )

        ),

    "seriesid" => 161
);

//print_r($a);



//set POST variables
$url = 'http://www.fopshvets.sc.ua/writelog.php';
$url = 'https://polza.com/app/core/activecampaign/webhook.php?inn2=1313';
$url = 'https://polza.com/app/core/activecampaign/webhook';
$url = 'http://polza.com/app/core/events/funnel_lms';
$url = 'https://polza.com/app/core/events/funnel_lms_1?key=3752&secret=glsfbgc&email=innetiad5@gmail.com&first_name=Serhii.Test3';
$url = 'https://polza.com/app/core/events/activecampain_lms_1.log';
$url = 'http://edison.polza.com/app/core/events/funnel_sms1.php?key=3752&secret=glsfbgc&first_name=Serhii.Test3';

//url-ify the data for the POST
$fields_string = http_build_query($a);

//open connection
echo "<br>-----get-----------<br>";
echo file_get_contents( $url);

echo "<br>-----get-----------<br>";
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch);
//curl_setopt($ch,CURLOPT_POST, 1);
//curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
$result = curl_exec($ch);
if (curl_error($ch)) {
    $error_msg = curl_error($ch);
	echo "<br>".$error_msg."<br>";
}
echo $result;

echo "<br><br><br>-----post-----------<br>";
//close connection
curl_close($ch);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch);
curl_setopt($ch,CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
$result = curl_exec($ch);
if (curl_error($ch)) {
    $error_msg = curl_error($ch);
	echo "<br>".$error_msg."<br>";
}
echo $result;

//close connection
curl_close($ch);

?>
