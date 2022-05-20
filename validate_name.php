<?php
	
	//get the data from the client
	$name = $_POST['name'];
	//connect to DB
	//$db = new SQLite3(getcwd().'/databases/chat.db'); 
	//$db = new SQLite3('/web/alh8007/webdev/macro_assignment_09/databases/chat.db');
	include('config.php');

	$sql = "SELECT * FROM badwords";
	$result = $db->query($sql);


	//check it
	if(!isset($name)) {
		print "missing"; //'missing' sent back to data on index.php
		exit();
	}

	//check string length of username
	if(strlen($name) >= 5 && ctype_alnum($name)){
		while($row=$result->fetchArray()){
		
			if(strpos($name, $row['word']) !== false){
				print "censored";
				exit();
			}

		}
		$user_ip = $_SERVER['REMOTE_ADDR'];
		//$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  

		//$name 
		$now = time();
		//$date = date('Y-m-d H:i:s');
		//$pretty_time = date("F j, Y, g:i a", $now);
		$info = "INSERT INTO visitors (ip, username, time) VALUES ('$user_ip','$name',$now)";
		
		$db->query($info);

		
		print "valid"; //'valid' sent back to data on index.php
		exit();
	}



	print "invalid"; //'invalid' sent back to data on index.php
	exit();

?>