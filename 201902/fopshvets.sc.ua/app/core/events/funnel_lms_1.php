<?

ini_set('display_errors', 0);
 $file = 'activecampain_lms_1.log';
 $current = "\r\n1 ".date("Y-m-d H:i:s")."\r\n".print_r($_REQUEST, true);
 file_put_contents($file, $current, FILE_APPEND); //echo "dddddd";
 
 ?>