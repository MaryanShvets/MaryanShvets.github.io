<?
	
class Todoist{

	// 0295e68f66c07fe9ccff5f7d0eaaa387c969b88c

	// https://todoist.com/api/v7/quick/add?token=0123456789abcdef0123456789abcdef01234567&task=test
	// $fields = array('token'=>$token,'task'=>$task;);

	public static function task($todo)
	{

		$time = Pulse::timer(false);

		$token = '0295e68f66c07fe9ccff5f7d0eaaa387c969b88c';
		$task = $todo.' today #теслафрендс !!1';

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,'https://todoist.com/api/v7/quick/add');
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
		    curl_setopt($ch,CURLOPT_POSTFIELDS,array('token'=>$token,'text'=>$task));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    return $out;

	    Pulse::log(Pulse::timer($time), 'core', 'lib_todoist', '0', '0', '0');
	}

	public static function add($todo, $token, $project)
	{
		$time = Pulse::timer(false);

		$task = $todo.' #'.$project;

		$ch=curl_init();
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_URL,'https://todoist.com/api/v7/quick/add');
		    curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
		    curl_setopt($ch,CURLOPT_POSTFIELDS,array('token'=>$token,'text'=>$task));
		    curl_setopt($ch,CURLOPT_HEADER,false);
	    $out=curl_exec($ch); 
	    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);

	    return $out;

	    Pulse::log(Pulse::timer($time), 'core', 'lib_todoist', '0', '0', '0');
	}

}

?>