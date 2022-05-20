<?php 

	//grab incoming data from register.php
	$username = $_POST['username'];
	$password = $_POST['password'];
	include('config.php'); //connect to database
	//validates username and password 

	$sql_validation = "SELECT * FROM logins WHERE username = '$username'";
	$checkresult = $db->query($sql_validation)->fetchArray();
	if($checkresult){
		print "taken";
		exit();
	}

	if(strlen($username) >= 5 && ctype_alnum($username) 
		&& strlen($password) >= 5 && ctype_alnum($password)){
		$salt = '7081323'; //secret salt
		$hashed_password = md5($password . $salt); //hashed password
		$sql_login = "INSERT INTO logins (username, password) VALUES ('$username', '$hashed_password')";
		$db->query($sql_login);
		$now = time();
		$sql_pings = "INSERT INTO pings (username, time) VALUES ('$username', $now)";
		$db->query($sql_pings);
		print "success"; //send data back and exit
		exit();
	}
	else{ //if username and password aren't valid
		print "fail";
		exit();
	}




?>