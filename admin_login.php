<?php
//grab data from client side
	$username=$_POST['username'];
	$password= $_POST['password'];

	if($username == 'andy' && $password == 'admin'){
		print "success";
		exit();
	}
	else if(empty($username) || empty($password)){
		print "empty";
		exit();
	}
	else{
		print "unsuccessful";
		exit();
	}






?>