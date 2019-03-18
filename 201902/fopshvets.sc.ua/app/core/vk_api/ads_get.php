<?
	
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/vk.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
MySQL::connect();

$app_id = '5564730';
$app_secure = 'z8liv1SYPiybMUALb1EW&redirect_uri';
$app_token = '2bda80372bda80372bda8037282b8e690d22bda2bda8037727432679446c70a2494e2f8';

// $page_id = 154803050;

// https://oauth.vk.com/authorize?client_id=5564730&display=page&redirect_uri=http://polza.com/callback&scope=ads&response_type=code&v=5.69
// https://oauth.vk.com/access_token?client_id=5564730&client_secret=z8liv1SYPiybMUALb1EW&redirect_uri=http://polza.com/callback&code=9053d33cab2ab74e5b

// 90f63a795c3428fa0ff2b1dec5012284c6fc1bf8597ddcfe542544b2f086b2ec530293e03bf4e8c106f3a
// $search_limit = 1000;
// $search_offset = 0;

// polza.com/app/core/vk_api/ads_get

// function get_members($page_id, $search_offset, $search_limit){

$data_parameters = array(
	'account_id'=>'1600034928',
	'campaign_ids'=>'[1008359371, 1008380463, 1008371898]'
);
$data = VK_API::request('ads.getAds', $data_parameters, '2a8036e7b22de60f2f39857bf9cf39a96b1210e8bb7c3282ea2fa7fea9d0e9caf5c205fc6303130fde626', '5.68');

$ids_list = '';
$ids_count = count($data['response']);

$i = 1;
foreach($data['response'] as $item){

	

	if ($i !== $ids_count) {
		$ids_list.= $item['id'].', ';
	}else{
		$ids_list.= $item['id'].'';
	}

	$i++;
}

$stat_parameters = array(
	'account_id'=>'1600034928',
	'ids_type'=>'ad',
	'ids'=>$ids_list,
	'period'=>'overall',
	'date_from'=>'0',
	'date_to'=>'0'
);

$stat = VK_API::request('ads.getStatistics', $stat_parameters, '2a8036e7b22de60f2f39857bf9cf39a96b1210e8bb7c3282ea2fa7fea9d0e9caf5c205fc6303130fde626', '5.68');

foreach ($stat['response'] as $key => $value) {
	$stat[$value['id']] = $value;
}

$leads = mysql_query(" SELECT COUNT(*) as `count`, `utmcontent` FROM `app_leads` WHERE `product` in('369', '368', '370') GROUP BY `utmcontent` ") or die(mysql_error());

$n = 0;
while ($row = mysql_fetch_array($leads)) {
	$leads_array[$row['utmcontent']] = $row['count'];
	$n++;
}

// echo '<pre>';
// print_r($data_array);

echo '<table cellspacing="0">';

foreach($data['response'] as $item){

	switch ($item['approved']) {
		case '0':
				$approved = 'Не отправлено';
			break;

		case '1':
				$approved = 'Ожидает модерации';
			break;

		case '2':
				$approved = 'Одобрено';
			break;

		case '3':
				$approved = 'Отклонено';
			break;
		
		default:
				$approved = 'Не отправлено';
			break;
	}

	switch ($item['status']) {
		case '0':
				$status = 'Остановлено';
			break;

		case '1':
				$status = 'Запущено';
			break;

		case '2':
				$status = 'Удалено';
			break;
		
		default:
				$status = 'Остановлено';
			break;
	}

	switch ($item['cost_type']) {
		case '0':
				$cost_type = 'CPC';
			break;

		case '1':
				$cost_type = 'CPM';
			break;
	}

	$id = $item['id'];

	$ads_spent = 0;

	if($stat[$id]['stats'][0]['spent']>=1){
		$ads_spent = $stat[$id]['stats'][0]['spent'];
	}	
	$ads_impressions = 0;

	if($stat[$id]['stats'][0]['impressions']>1){
		$ads_impressions = $stat[$id]['stats'][0]['impressions'];
	}	

	$ads_clicks = 0;

	if($stat[$id]['stats'][0]['clicks']>=1){
		$ads_clicks = $stat[$id]['stats'][0]['clicks'];
	}	

	$ads_leads = 0;

	if($leads_array[$id] >=1 ){
		$ads_leads = $leads_array[$id];
	}	

	$cpa = round($ads_spent / $ads_leads);

	// $ctr = round($ads_clicks / $ads_impressions * 100);

	if ($cpa <= 100 && $cpa != 0) {
		$cpa_good = 'yes';
	}else{ $cpa_good = 'no';}

	$limit = round($ads_spent / $item['all_limit'] * 100);

	echo '<tr class="status_'.$item['status'].' approved_'.$item['approved'].'">';

		echo '<td>';
			echo '<span class="id"><a href="https://vk.com/ads?act=office&union_id='.$id.'" target="_blank">'.$id.' '.$cost_type.'</a></span>';
		echo '</td>';

		echo '<td>';
			echo '<span class="status">'.$status.' / '.$approved.'</span>';
		echo '</td>';

		echo '<td>';
			echo '<span class="leads">'.$ads_leads.' лидов</span>';
		echo '</td>';

		echo '<td>';
			echo '<span class="cpa '.$cpa_good.'">'.$cpa.' за лида</span>';
		echo '</td>';

		echo '<td>';
			echo '<span class="cr">'.round($ads_leads / $ads_clicks * 100).'%</span>';
		echo '</td>';

		echo '<td>';
			echo '<span class="clicks">'.$ads_clicks.' кликов</span>';
		echo '</td>';

		echo '<td>';
			echo '<span class="cpc">'.round($ads_spent / $ads_clicks).' cpc</span>';
		echo '</td>';


		echo '<td>';
			echo '<span class="ctr">'.round($ads_clicks / $ads_impressions * 100, 3).'%</span>';
		echo '</td>';

		echo '<td>';
			echo '<span class="impressions">'.number_format($ads_impressions).' показов</span>';
		echo '</td>';

		// echo '<td>';
		// 	echo '<span class="impressions">'.$stat[$id]['stats'][0]['reach'].' охват</span>';
		// echo '</td>';
		
		echo '<td>';
			echo '<span class="spent">'.$ads_spent.' р. ('.$limit.'%)</span>';
		echo '</td>';


		// echo '<td>';
		// 	echo '<span class="spent">'.$ads_spent.' рублей</span>';
		// 	echo '<span class="impressions">'.$ads_impressions.' показов</span>';
		// 	echo '<span class="clicks">'.$ads_clicks.' кликов</span>';
		// 	echo '<span class="leads">'.$ads_leads.' лидов</span>';
		// echo '</td>';


		// echo '<td>';
		// 	echo '<span class="all_limit">'.$item['all_limit'].' лимит</span>';
		// 	// echo '<span class="cost_type">'.$cost_type.'</span>';
		// echo '</td>';

	echo '</tr>';

}

echo '</table>';

?>

<link href="https://fonts.googleapis.com/css?family=Roboto:100,400,300,900&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">

<style type="text/css">

	body{
		font-family: 'Roboto', sans-serif;
		margin: 0;
		padding: 0;
		font-weight: 100;
		font-size: 18px;
		background: rgb(248, 248, 248);
	}

	table{
		box-shadow: 0px 0px 5px rgb(227, 227, 227);
		/*background: white;*/
		margin-bottom: 50px;
		border-radius: 2px;
		width: 90%;
		max-width: 1800px;
		margin-right: auto;
		margin-left: auto;
		margin-top: 50px;
		margin-bottom: 50px;
		    font-weight: 100;
	}
	table tr{
		margin: auto;
		margin-top: 5px;
		margin-bottom: 5px;
		padding: 5px;
		width: 100%;
		background: white;
		box-sizing: border-box;
		border-radius: 2px;
		transition: all 0.6s;
	}
	table tr:hover{
		cursor: pointer;
	}
	table tr:hover >td{
		background: rgb(244, 244, 244);
	}
	table tr.status_1:hover >td{
		background: #52a3f5;
	}
	tr.status_0{
	    /*opacity: 0.3;*/
	    /*color: #00000033;*/
    	/*background: #d0d0d0;*/
	}
	tr.status_1{background: #0f82f6;
    color: white;}
	tr.status_2{}
	tr.approved_1{
		    background: #fffbb5;
	}
	tr.approved_3{
		    opacity: 0.3
	}
	td{
		padding: 10px 20px;
		border-bottom: 1px solid rgb(236, 236, 236);
	}
	a{
		    color: inherit;
    text-decoration: none;
	}
	.id{
		display: inline-block;
   	width: 100%;
	}
	.status{
		display: inline-block;
   	width: 100%;
	}
	.approved{
		display: inline-block;
   	width: 100%;
	}
	.spent{
		display: inline-block;
   	width: 100%;
	}
	.impressions{
		display: inline-block;
   	width: 100%;
	}
	.clicks{
		display: inline-block;
   	width: 100%;
	}
	.all_limit{
		display: inline-block;
   	width: 100%;
	}
	.cost_type{
		display: inline-block;
   	width: 100%;
	}
	.cpc{
		display: inline-block;
   	width: 100%;
	}
	.cpa{
		/*display: inline-block;
   	width: 100%;*/
	}
	tr.status_0 .cpa.yes{
		/*display: inline-block;
   	width: 100%;*/
   	color: #0f82f6;
   	    font-weight: 400;
	}
	.cpa.no{
		/*display: inline-block;
   	width: 100%;*/
	}
	.cpm{
		display: inline-block;
   	width: 100%;
	}
	.cr{
		display: inline-block;
   	width: 100%;
	}
</style>