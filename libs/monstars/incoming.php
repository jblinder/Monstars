<?
/*
	TODO: still need to settle on what the frontend will recieve from the aparser class.
*/

//import depedencies
require_once("../../../../private/mysql_connect_monstars.php");
require_once('parser.php');

//retrieve url vars !!!!!!!!!!!CHANGE TO POST AFTER TESTING
$user   = $_GET['user'];  //user
$enemy  = $_GET['enemy']; //enemy
$type   = $_GET['type'];

$parser	   = new parser();
$json_user = $parser->init($user, $type);

if($enemy) $json_matchup  = $parser->init_compare($user, $enemy, $type);

echo json_encode(array_merge($json_user, $json_matchup));

?>