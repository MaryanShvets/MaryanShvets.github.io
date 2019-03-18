<?
	
class MySQL{

	public static function connect(){
		$host = 'localhost';
		$user = 'kirgkybv_plzapp';
		$pswd = '#ZN+]kN+eR,N';
		$db = 'kirgkybv_polza_app';
		
		$connection = mysql_connect($host, $user, $pswd);
		mysql_query("SET NAMES utf8");
		if(!$connection || !mysql_select_db($db, $connection)){return false;}
	}

	public static function query($q){
    	$result = mysql_query($q);
		$row = mysql_fetch_array($result);
		return $row;
    }

}

?>