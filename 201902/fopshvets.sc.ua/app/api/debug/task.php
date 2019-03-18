<?

	ini_set('display_errors', 1);
	ini_set('date.timezone', 'Europe/Kiev');
	// $date_now = date("M-d-Y H:i", strtotime('+7 hours'));
	// echo $date_now;
	// echo '<br>';
 //    $date = date("H", strtotime('+7 hours'));

 //    if ($date >= '00' && $date <= '08') 
 //    {
 //        // $complete_till = strtotime($date_task);

 //        echo 'сделай утром <br>';
 //    } 
 //    elseif ($date >= '18' && $date <= '23')
 //    {
 //        // $date_task = strtotime($date_task);
 //        // $complete_till = strtotime("+1 day", $date_task);
 //        echo 'сделай завтра <br>';
 //    } 
 //    elseif ($date >= '09' && $date <= '18')
 //    {
 //        // $complete_till = strtotime("+30 minute");
 //        $date_now = strtotime($date_now);
 //        // $complete_till = strtotime("+30 minute", $date_now);

 //        $complete_till = date($date_now, strtotime('+30 minute'));
 //        echo 'сделай через 30 минут <br>';
 //    }

 //    echo $complete_till;

	$date_task = date("M-d-Y 9:30");
    $date = date("H");
    if ($date >= '00' && $date <= '08') 
    {
        $complete_till = strtotime($date_task);
    } 
    elseif ($date >= '18' && $date <= '23')
    {
        $date_task = strtotime($date_task);
        $complete_till = strtotime("+1 day", $date_task);
    } 
    elseif ($date >= '09' && $date <= '18')
    {
        $complete_till = strtotime("+30 minute");
    }

    echo $complete_till;

    // echo $date;
    // amo_add_task($id, $manager, $text);
?>