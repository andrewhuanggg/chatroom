<?php 
	
	//grab incoming variables 
	$username = $_POST['username'];
	$password = $_POST['password'];
	include('config.php'); //connect to database
	$salt = '7081323'; //secret salt
	$hashed_password = md5($password . $salt); //hashed password


	
	//sql query
	$sql = "SELECT * FROM logins WHERE (username = '$username' AND password = '$hashed_password')";
	$result = $db->query($sql)->fetchArray(); //checks to see if this username/password combo exists

	

	if($result){
		//start session
		session_start();

		//generate new PHPSESSID 
		session_regenerate_id();

		$_SESSION['loggedin'] = 'yes';
		$_SESSION['username'] = $username;
		print "success"; //send data back 
		exit();

	} 

	else{
		print "fail"; //send data back 
		exit();
	}






?>