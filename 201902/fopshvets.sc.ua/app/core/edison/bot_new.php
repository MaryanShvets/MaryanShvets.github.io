<?

include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/mysql.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/pulse.php');
include( $_SERVER['DOCUMENT_ROOT'].'/app/core/lib/memory.php');
$bots_memory = Memory::load('bots_config');

$bot = $_POST['bot'];

$new_bots_memory = $bots_memory;
$new_bots_memory[$bot]['id'] = 'none';
$new_bots_memory[$bot]['token'] = 'none';

Memory::save('bots_config', $new_bots_memory);

?>