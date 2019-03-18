<style type="text/css">
	
	body{
		background: #f5f5f5;
		/*text-align: center;*/
	}
	.board{

	}
	.list {
    display: inline-block;
    width: 20%;
    text-align: center;
    background: #ffffff;
    border-radius: 3px;
    margin: 10px;
    padding: 16px;
    color: black;
    font-weight: 100;
    text-decoration: none;
    font-family: sans-serif;
    font-weight: lighter;
    box-shadow: 1px 1px 3px #d2d2d2;

}
	.card {
    display: inline-block;
    width: 46%;
    text-align: center;
    background: #ffffff;
    border-radius: 3px;
    margin: 10px;
    padding: 16px;
    color: black;
    text-decoration: none;
    font-family: sans-serif;
    font-weight: lighter;
    box-shadow: 1px 1px 3px #d2d2d2;
    box-sizing: border-box;
}
</style>

<?

	// Отображение ошибок (1 – показывать, 0 – скрывать)
	ini_set('display_errors', 0);

	// https://developers.trello.com/advanced-reference/card#get-1-cards-card-id-or-shortlink

	$auth = '46bef73ddf94210f2b70614e2d11986afaee7ec1b7b74490cba2c61e1915f002';
	$key = '2dc1391b82826f95c9f43b7dafafaa93';
	// $board = 'IRcKVbSL';
	$board = 'RtZgkklC'; // mind

	if (empty($_GET['list'])) {

		$url = 'https://api.trello.com/1/boards/'.$board.'?lists=open&list_fields=name&fields=name,desc&key='.$key.'&token='.$auth;
		$result = json_decode(file_get_contents($url));

		foreach ($result->lists as $key => $value) {
			$value = (array)$value;
			echo '<a class="list" href=\'?view=trello&list='.$value['id'].'\'>'.$value['name'].'</a>';
		}
	}elseif(!empty($_GET['list'])&&empty($_GET['card'])){
		$list = $_GET['list'];
		$url = 'https://api.trello.com/1/lists/'.$list.'?view=trello&fields=name&cards=open&card_fields=name&key='.$key.'&token='.$auth;

		$result = json_decode(file_get_contents($url));

		foreach ($result->cards as $key => $value) {
			$value = (array)$value;
			echo '<a class="card" href=\'?view=trello&list='.$list.'&card='.$value['id'].'\'>'.$value['name'].'</a>';
		}

	}elseif(!empty($_GET['card'])){

		$card = $_GET['card'];
		$url = 'https://api.trello.com/1/cards/'.$card.'?view=trello&fields=badges,checkItemStates,closed,dateLastActivity,desc,descData,due,email,idBoard,idChecklists,idLabels,idList,idMembers,idShort,idAttachmentCover,manualCoverAttachment,labels,name,pos,shortUrl,url&member_fields=fullName&key='.$key.'&token='.$auth;

		$result = json_decode(file_get_contents($url));

		echo '<pre>';
		print_r($result);
	}


?>