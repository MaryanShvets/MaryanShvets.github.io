<?

ini_set('display_errors', 0);

$file = 'activecampain.log';

// Добавляем нового человека в файл
$current = "\r\n".date("Y-m-d H:i:s")."\r\n".print_r($_REQUEST, true);
file_put_contents($file, $current, FILE_APPEND);
//echo "dddddd";
?>