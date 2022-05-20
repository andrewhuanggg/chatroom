<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Create an Account</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>
	<h2>Create an Account and Start Chatting!</h2>
	<div id="reg_status"></div> 
 	<div id="register_account">
			Username: <input type="text" id="username"><br>
			Password: <input type="text" id="password">
			<input type="submit" value="Create Account" id="create_account"> 
	</div>
	<p>Note: Username and Password must be at least 5 characters long and must be alphanumeric. If registration is successful, you will be brought back to the login page, where you can enter your new credentials and start chatting!</p>

	<script type="text/javascript">
		$(document).ready(function(){
			let username = document.getElementById('username');
			let password = document.getElementById('password');
			let register_account = document.getElementById('register_account');
			let reg_status = document.getElementById('reg_status');
			let create_account = document.getElementById('create_account')

			create_account.addEventListener('click',function(){
			//validate the user's name using AJAX call to the server 
				//console.log(username.value)
				//console.log(password.value)
				$.ajax({
					url: 'create_account.php',
					type: 'post',
					data: {
						username: username.value,
						password: password.value 
					},
					success: function(data, status){
						console.log(data)
						if(data=='success'){
							
							location.href = 'index.php';
						}
						else if(data == 'fail'){
							reg_status.innerHTML = 'Invalid username or password, try again!'
						}

						else if(data == 'taken'){
							reg_status.innerHTML = 'Username is already taken!'
						}

					}
						
				});
			

			})
		})
		
		
	</script>

</body>
</html>