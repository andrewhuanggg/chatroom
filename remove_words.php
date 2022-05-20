<?php 

$word = $_POST['word'];
//connect to database
//$db = new SQLite3(getcwd().'/databases/chat.db');
//$db = new SQLite3('/web/alh8007/webdev/macro_assignment_09/databases/chat.db');
include('config.php');
$select = "SELECT * FROM badwords";
$result = $db->query($select);
$exists = false;
while($row=$result->fetchArray()){
	if($word==$row['word']){
		$exists = true;
	}
}
//insert word into database with query
if($exists == true){
	$sql = "DELETE FROM badwords WHERE word = '{$word}'";
	$db->query($sql);
	print "success";
	exit();
}
else{
	print "invalid";
	exit();
}



?>