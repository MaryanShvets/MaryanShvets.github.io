<?

class Pulse{

	public static function timer($t){
		if ( empty($t) ) {
			return microtime(true);
		}else{

			$start = $t;
			$end = microtime(true);
			return number_format(($end - $start), 5);
		}
	}

	public static function log($t, $k1,$k2,$k3,$k4,$k5){
		
		MySQL::connect();

		$now = date("Y-m-d H:i:s", strtotime('+6 hours'));

		$sql = " INSERT INTO `app_pulse` ";
	    $sql.= "( `datetime`, `time`, `key1`, `key2`, `key3`, `key4`, `key5`) ";
	    $sql.= " VALUES ";
	    $sql.= "('$now', '$t', '$k1', '$k2', '$k3', '$k4', '$k5')";

	    mysql_query($sql) or die(mysql_error());
		mysql_close();
	}
}

?>