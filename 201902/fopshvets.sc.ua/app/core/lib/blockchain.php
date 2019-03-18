<?

class Blockchain{

	public static function curl($url){

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch,CURLOPT_URL, $url );
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST, 'GET' );
		curl_setopt($ch,CURLOPT_HEADER, false );
		$out = curl_exec($ch); 
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		if ($code == 200) {
			return json_decode($out, JSON_OBJECT_AS_ARRAY);
		}else{
			return false;
		}
	}

	public static function block_new($data){
		
		$data_url = $_SERVER['DOCUMENT_ROOT'].'/app/core/blockchain/blocks/'.$data['hash'].'.json';
		file_put_contents($data_url, json_encode($data));

		return Blockchain::curl('http://polza.com/app/core/blockchain/data_mempool.json');
	}

	public static function mempool_get(){

		return Blockchain::curl('http://polza.com/app/core/blockchain/data_mempool.json');
	}

	public static function mempool_new($data){

		$data_url = $_SERVER['DOCUMENT_ROOT'].'/app/core/blockchain/data_mempool.json';
		file_put_contents($data_url, json_encode($data));

		return Blockchain::curl('http://polza.com/app/core/blockchain/data_mempool.json');
	}

	public static function index_get(){

		return Blockchain::curl('http://polza.com/app/core/blockchain/data_index.json');
	}

	public static function record_new($data){

		$mempool = Blockchain::mempool_get();

		$records_count = count($mempool['queue']);

		if ($records_count <= 50) {
			
			$data['hash'] = hash('sha256', json_encode($data));

			$mempool['queue'][] = $data;
			Blockchain::mempool_new($mempool);
		}
		else{

			$mempool['queue'][] = $data;

			$json_records = json_encode($mempool['queue']);
			$hash = hash('sha256', $json_records);

			$new_block = array(
				'height'=>$mempool['height']+1,
				'records'=>$records_count,
				'data'=>$mempool['queue'],
				'hash'=>$hash,
				'previusHash'=>$mempool['lastHash']
			);

			Blockchain::block_new($new_block);

			$new_mempool = array('height'=>$mempool['height']+1,'lastHash'=>$hash);
			Blockchain::mempool_new($new_mempool);
		}
	}
}

?>