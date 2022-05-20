<?php 

$word = $_POST['word'];
//connect to database
//$db = new SQLite3(getcwd().'/databases/chat.db');
//$db = new SQLite3('/web/alh8007/webdev/macro_assignment_09/databases/chat.db');
include('config.php');

//insert word into database with query
if($word){
	$sql = "INSERT INTO badwords (word) VALUES ('{$word}')";
	$db->query($sql);
	print "success";
	exit();
}
else{
	print "invalid";
	exit();
}




?>