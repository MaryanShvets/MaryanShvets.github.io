<?


include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');
MySQL::connect();

$id = $_POST['id'];

$affilate_data = MySQL::query( " SELECT * FROM `app_affilate_payments` WHERE `id` = $id LIMIT 1" );
$partner_id = $affilate_data['affilate'];
$client_lead_id = $affilate_data['sub_id'];

$partner = MySQL::query(" SELECT * FROM `app_contact` WHERE `id` ='$partner_id' LIMIT 1");
$client = MySQL::query(" SELECT * FROM `app_contact` WHERE id IN (SELECT `contact` FROM `app_leads` WHERE `id` = '$client_lead_id' )  LIMIT 1");

$notconfirmed_sum = 0;
$notconfirmed_count = 0;
$notpaid_sum = 0;
$notpaid_count = 0;

$affilate_summ = mysql_query( " SELECT `amount`,`status` FROM `app_affilate_payments` WHERE `affilate` = $partner_id AND (`status` = '1' OR `status` ='2' ) " );
$last_unpaid_data = MySQL::query( " SELECT `date_event` FROM `app_affilate_payments` WHERE `affilate` = $partner_id AND  `status` ='2' ORDER BY `date_event` DESC LIMIT 1  " );

while ($value = mysql_fetch_array($affilate_summ)) {

	if ($value['status'] == '1') {
		
		$notconfirmed_sum = $notconfirmed_sum + $value['amount'];
		$notconfirmed_count++;
	}
	elseif ($value['status'] == '2') {
		
		$notpaid_sum = $notpaid_sum + $value['amount'];
		$notpaid_count++;
	}

}

echo '<strong>Информация про партнера // <a style="color:#0f82f6;" target="_blank" href="http://polza.com/app/core/affilate/user_mask?client='.$partner_id.'">Войти в кабинет</a></strong><br>';

echo '<strong>Имя </strong> ';
echo $partner['name'].'<br>';

echo '<strong>Емейл </strong> ';
echo $partner['email'].'<br>';

echo '<strong>Телефон </strong> ';
echo $partner['phone'].'<br>';

echo '<strong>Неподвержденных</strong> ';
echo '$'.$notconfirmed_sum.' ('.$notconfirmed_count.')<br>';

echo '<strong>Невыплаченных</strong> ';
echo '$'.$notpaid_sum.' ('.$notpaid_count.')<br>';

echo '<strong>Дата первого невыплаченного</strong> ';
echo $last_unpaid_data['date_event'].'<br>';

echo '<br>';

echo '<strong>Информация про клиента</strong><br>';

echo '<strong>Имя </strong> ';
echo $client['name'].'<br>';

echo '<strong>Емейл </strong> ';
echo $client['email'].'<br>';

echo '<strong>Телефон </strong> ';
echo $client['phone'].'<br>';



?>


<script type="text/javascript">
	$(document).ready(function() { 

		$('#modal_system_head').html('<span onclick="modal_system_close()">Закрыть</span>');

	});
</script>