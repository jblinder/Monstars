<?
//import depedencies
require_once("../../../../private/mysql_connect_monstars.php");
require_once('parser.php');

//retrieve url vars !!!!!!!!!!!CHANGE TO POST AFTER TESTING
$user   = $_GET['user'];  //user
$enemy  = $_GET['enemy']; //enemy
$type   = $_GET['type'];

$parser = new parser();
$json_user   = $parser->init($user, $type);
if($enemy) $json_enemy  = $parser->init($enemy, $type);

echo json_encode(array_merge($json_user, $json_enemy));

/*
//setup sql statements

$sql_checkuser  =  'SELECT * from user where username="'.$name.'"';
$sql_insertuser =  'INSERT INTO user (username,energy,wins,loses) VALUES ("'.$name.'", 10, 0,0)';
$sql_updateuser =  'UPDATE '
echo $sql_checkuser;
//query mysql
$query = mysql_query($sql_checkuser);
//super hackish way of testing if the user exists
$count = 0;
while ($row = mysql_fetch_assoc($query)){
	$count = 1;
}

if($count == 0){
	echo "user does not exist";	
}
else{
	
}

//parse and return data
$parser = new parser();
$json   = $parser->init($name, $type);
*/
//print_r($json);

?>