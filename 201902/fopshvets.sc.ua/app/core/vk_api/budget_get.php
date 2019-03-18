<?
	
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/vk.php');

$app_id = '5564730';
$app_secure = 'z8liv1SYPiybMUALb1EW&redirect_uri';
$app_token = '2bda80372bda80372bda8037282b8e690d22bda2bda8037727432679446c70a2494e2f8';

// $page_id = 154803050;

// https://oauth.vk.com/authorize?client_id=5564730&display=page&redirect_uri=http://polza.com/callback&scope=ads&response_type=code&v=5.69
// https://oauth.vk.com/access_token?client_id=5564730&client_secret=z8liv1SYPiybMUALb1EW&redirect_uri=http://polza.com/callback&code=5f77d1dc25e75c1521

// 90f63a795c3428fa0ff2b1dec5012284c6fc1bf8597ddcfe542544b2f086b2ec530293e03bf4e8c106f3a
// $search_limit = 1000;
// $search_offset = 0;

// polza.com/app/core/vk_api/ads_get

// function get_members($page_id, $search_offset, $search_limit){

$parameters = array(
	// 'access_token'=>'90f63a795c3428fa0ff2b1dec5012284c6fc1bf8597ddcfe542544b2f086b2ec530293e03bf4e8c106f3a',
	'account_id'=>'1600034928',
	'ids_type'=>'ad',
	'ids'=>'38269111, 38269086, 38269066, 38269031, 38269012, 38268986, 38268971, 38268958, 38268945, 38268916, 38267889, 38267880, 38267864, 38267801, 38267753, 38267731, 38267710, 38267695, 38267674, 38267651, 38267632, 38267613, 38267583, 38227011, 38222708',
	'period'=>'overall',
	'date_from'=>'0',
	'date_to'=>'0'
);

$data = VK_API::request('ads.getStatistics', $parameters, '90f63a795c3428fa0ff2b1dec5012284c6fc1bf8597ddcfe542544b2f086b2ec530293e03bf4e8c106f3a', '5.68');


echo '<pre>';
print_r($data);

?>