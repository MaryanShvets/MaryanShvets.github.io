<?

class Access{

	public static function finance($type, $system){

		switch ($type) {

			case 'random':
				$sql_request = " SELECT * FROM `app_payments_config` ";
				$sql_request.= " WHERE `system` = '".$system."' AND `status` = 'active' ";
				$sql_request.= " ORDER BY RAND () LIMIT 1 ";

				$result = mysql_query($sql_request);
				$row = mysql_fetch_array($result);
				return $row;
			break;
		}
	}

	public static function pass($service){

	}
}

?>