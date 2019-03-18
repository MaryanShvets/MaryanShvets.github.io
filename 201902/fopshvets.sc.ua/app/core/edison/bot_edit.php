<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');
$bots_memory = Memory::load('bots_config');


$bot = $_POST['bot'];
$id = $_POST['id'];
$token = $_POST['token'];

$new_bots_memory = $bots_memory;

$new_bots_memory[$bot]['id'] = $id;
$new_bots_memory[$bot]['token'] = $token;

Memory::save('bots_config', $new_bots_memory);

?>