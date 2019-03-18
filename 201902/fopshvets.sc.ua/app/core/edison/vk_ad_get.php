<?

$id = $_GET['id'];

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/vk.php');

$app_id = '5564730';
$app_secure = 'z8liv1SYPiybMUALb1EW&redirect_uri';

$data_parameters = array(
	'account_id'=>'1600034928',
	'ad_ids'=>'['.$id.']'
);

$data = VK_API::request('ads.getAdsLayout', $data_parameters, '2a8036e7b22de60f2f39857bf9cf39a96b1210e8bb7c3282ea2fa7fea9d0e9caf5c205fc6303130fde626', '5.68');

echo '<strong>'.$data['response'][0]['title'].'</strong>';

?>