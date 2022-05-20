<?php 

	//open database
	//$db = new SQLite3(getcwd().'/databases/chat.db');
	//$db = new SQLite3('/web/alh8007/webdev/macro_assignment_09/databases/chat.db');
	include('config.php');
	//get post variables
	$name = $_POST['name'];
	$message = $_POST['message'];
	$sql = "SELECT * FROM badwords";
	$result = $db->query($sql);
	//make sure there's a message here 
	if(strlen($message) > 0){

		while($row=$result->fetchArray()){
		
			if(strpos($message, $row['word']) !== false){
				print "censored";
				exit();
			}

		}
		//add to database
		$message = $db->escapeString(addslashes(htmlspecialchars($message))); //prepare a string 
		//so that internal delimiters don't interfere with query operation
		//makes chars html safe 

		//send result
		
		$sql = "INSERT INTO chats (name,message) VALUES ('$name', '$message')";
		//$sql = "INSERT INTO chats (name, message, roomid) VALUES ('$name', '$message', '$roomid')";
		$db->query($sql); 
		print "success";
		exit();
	}
	/*
	if(strlen($message)<1){
		print "fail";
		exit();
	}*/
	/*
	while($row=$result->fetchArray()){
		//if($row['word'])
		if(strpos($message, $row['word']) !== false){
			print "censored";
		}
	}*/
	print "fail";
	exit();

	 
?>