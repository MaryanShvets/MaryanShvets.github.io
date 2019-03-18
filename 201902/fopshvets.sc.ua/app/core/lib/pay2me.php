<?php 

class Pay2MeApi
{
    public $apiKey = 'Mrxdob5d5gAoQ3RLNiXpaDJHzPIIbhMY';
    public $secretKey = 'TmTaJLdj';
    public $apiUrl = 'https://api.pay2me.world';
    private $apiVersion = 'v3';
    /**
     * @param string $order_id
     * @param $order_return
     * @param $order_desc
     * @param $order_amount
     * @return mixed
     */
    public function dealCreate($order_id, $order_desc, $order_amount, $order_return) {
        return $this->transport('/api/'.$this->apiVersion.'/deals',["order_id" => $order_id, "order_return" => $order_return, "order_desc" => $order_desc, "order_amount" => $order_amount]);
    }
    /**
     * @param string $object_id
     * @return mixed
     */
    public function dealStatus($object_id) {
        return $this->transport('/api/'.$this->apiVersion.'/deals/status/'.$object_id,[],'GET');
    }
    /**
     * @param string $object_id
     * @return mixed
     */
    public function dealComplete($object_id) {
        return $this->transport('/api/'.$this->apiVersion.'/deals/complete/'.$object_id,[],'PUT');
    }
    /**
     * @param array $object_ids
     * @return mixed
     */
    public function dealsComplete($object_ids=[]) {
        return $this->transport('/api/'.$this->apiVersion.'/deals/complete',['deals'=>$object_ids],'PUT');
    }
    /**
     * @param string $object_id
     * @return mixed
     */
    public function dealCancel($object_id) {
        return $this->transport('/api/'.$this->apiVersion.'/deals/cancel/'.$object_id,[],'PUT');
    }
    /**
     * @param string $path
     * @param array $params
     * @return mixed
     */
    public function transport($path, $params=[],$method='POST') {
        $params['signature'] = $this->getSignature($params);
        $data_string = json_encode($params);
        $curl = curl_init($this->apiUrl.$path);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'X-API-KEY: '.$this->apiKey,
            'Accept: application/json',
        ));
        $json = curl_exec($curl);
        $result = json_decode($json);
        return $result;
    }
    /**
     * @param array $params
     * @return string
     */
    private function getSignature($params=array()) {
        ksort($params);
        $a = array();
        foreach ($params as $key => $val) {
            $a[]=$val;
        }
        return md5(implode("", $a).$this->secretKey);
    }
}

?>