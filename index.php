<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Let's Chat</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<style type="text/css">
		#chat_log {
			display: block;
			width: 500px;
			height: 300px;
			/*float: left;*/
		}
		#users_list {
			display: block;
			height: 300px;
			float: left;
		}
		#message {
			width: 555px;
		}
		.hidden {
			display: none;
		}


	</style>
</head>
<body>
	<h1>Let's Chat</h1>
	
	<div id="nameval"></div>
	

	<div id="panel_name">
		
		Username: <input type="text" id="username"><br>
		Password: <input type="text" id="password">
		<input type="submit" value="Login" id="submit_login"> 
		
	</div>	
	<a href="register.php" id="registration">Register for an account</a>
	<a href="admin_panel.php" class="hidden">Admin Login</a><br>

	<div id="panel_chat" class="hidden">
		
		

		<!--<a href="logout.php"><button id="button_logout" class='hidden'>Log Out</button></a>-->
		<a href="logout.php" id="button_logout">Log Out</a>
		<br><br>
		<textarea readonly id="users_list"></textarea>
		<textarea readonly class = "hidden" id="chat_log"></textarea> 
		
		<input type="text" id="message"> 
		<button id="button_send">Send Message</button>
	</div>
	<div id="messageval"></div>
	<div id="censorval"></div>

	<script type="text/javascript">
		let selectedName;
		$(document).ready(function(){
			let panel_name = document.getElementById('panel_name')
			let username = document.getElementById('username')
			let password = document.getElementById('password')
			let button_save = document.getElementById('button_save')
			let panel_chat = document.getElementById('panel_chat')
			let chat_log = document.getElementById('chat_log')
			let message = document.getElementById('message')
			let button_send = document.getElementById('button_send')
			let nameval = document.getElementById('nameval')
			let valcount = 0;
			let messageval = document.getElementById('messageval') //validation message
			let censorval = document.getElementById('censorval')
			let button_namechange = document.getElementById('button_namechange')
			let namechange = document.getElementById('namechange')
			let changeval = document.getElementById('changeval')
			let oldchat = [];
			let scroll = true;
			let newMessages;
			let v = 0; //iterator for 
			let chooseChat = document.getElementById('chooseChat')
			let button_choose = document.getElementById('button_choose')
			let sports_chat = document.getElementById('sports_chat')
			let school_chat = document.getElementById('school_chat')
			let games_chat = document.getElementById('games_chat')
			let currentChat = '';
			let submit_login = document.getElementById('submit_login')
			let registration = document.getElementById('registration')
			let button_logout = document.getElementById('button_logout')
			let users_list = document.getElementById('users_list')
			<?php 
				
				//$username = $_COOKIE['username'];
				
				//if($_COOKIE['PHPSESSID'] && session_status() === PHP_SESSION_NONE){
				//	session_start();
				if($_COOKIE['PHPSESSID']){
					session_start();
				?>

					panel_name.classList.add('hidden')
					registration.classList.add('hidden')
					panel_chat.classList.remove('hidden')
					button_logout.classList.remove('hidden')
					
				<?php
					//connect to DB and update visitors time 
					$currentuser = $_SESSION['username'];
					//$db = new SQLite3(getcwd().'/databases/chat.db'); 
					//$db = new SQLite3('/web/alh8007/webdev/macro_assignment_09/databases/chat.db');
					include('config.php');
					$now = time();
					$update = "UPDATE visitors SET time = $now WHERE username = '{$currentuser}'";
					$db->query($update);
				}
				if(!($_SESSION['username'])){
				?>
					panel_chat.classList.add('hidden')
				<?php
				}
			?>

			submit_login.addEventListener('click', function(){
				$.ajax({
					url: 'login.php',
					type: 'post',
					data: {
						username: username.value,
						password: password.value 
					},
					success: function(data, status){
						if(data == 'success'){
							location.reload()
							<?php //session_start(); ?>
							selectedName = username.value
							panel_name.classList.add('hidden');
							registration.classList.add('hidden')
							panel_chat.classList.remove('hidden');
							button_logout.classList.remove('hidden');
							nameval.innerHTML = "";
						}
						else{
							nameval.innerHTML = "Username or password is incorrect!";


						}
					}

				})
			})

			
			
			


			button_send.addEventListener('click',function() {
				//make an ajax call to the server to save the message
				$.ajax({
					url: 'save_message.php',
					type: 'post',
					data: {
						//name: selectedName,
						name:  <?php echo json_encode($_SESSION['username']); ?>,
						message: message.value
					},
					success: function(data, status) {
						//console.log(selectedName)
						
						
						if (!(selectedName)){
							selectedName = <?php echo json_encode($_SESSION['username']); ?>
							//console.log("no name")
						}
						//console.log(selectedName)
						//console.log(selectedName)
						if(data == 'fail'){
							messageval.innerHTML = "Please enter a valid message!";
							console.log("FAILED")
						}

						else if(data == 'censored'){

							messageval.innerHTML = "Censored word detected! Failed to send message.  ";
						}
						else{
							chat_log.value += selectedName + ': ' + message.value + "\n";
							
							message.value = "";
							messageval.innerHTML = ""; //no validation message
							censorval.innerHTML = "";
						}
						
						//checkTextareaHeight();
						
					}
				});
				//when it's successful we should add message to chat log 
			})

			message.addEventListener('keyup', function(event){
				//check if ENTER is pressed
				if (event.keyCode == 13){
					button_send.click();
				}
			});

			

			let mouselocation = false;
			chat_log.addEventListener('mouseover', function(){
				mouselocation = true; //mouse is inside chat log
			})
			chat_log.addEventListener('mouseout', function(){
				mouselocation = false; //mouse is outside of chat log
			})

			function getData() {
				if (!(selectedName)){
					selectedName = <?php echo json_encode($_SESSION['username']); ?>
							//console.log("no name")
				}
				
				$.ajax({
					url: 'get_messages.php',
					type: 'post',
					data:{
						username: selectedName
					},
					success: function(data, status) {
						//console.log(data)
						let parsed = JSON.parse(data);
						let newChatroom = '';
						let onlineUsers = '';
						
						let userData = parsed['pings'];
						for(let i = 0; i < userData.length; i++){
							onlineUsers += userData[i].username + "\n";
						}
						console.log(parsed['pings'])
						users_list.value = onlineUsers;
		
						let chatData = parsed['chat'];
						for(let i = 0; i < chatData.length; i++){
							newChatroom += chatData[i].name + ': ' + chatData[i].message +"\n"
						}
						chat_log.value = newChatroom;
						oldchat[v] = newChatroom.length;
						if(v > 0 && oldchat[v-1]<oldchat[v]){ //checks to see if new chats came in 
							//alert("new message!")
							newMessages = true;
						}
						else if(v > 0 && oldchat[v-1] == oldchat[v]){
							newMessages = false;
							//alert("no new message")
						}
						v++;

						
						
						if(newMessages == true && mouselocation == false){
							//chat_log.addEventListener('mouseout',scrollDown);
							scrollDown();
						}
						
						

						setTimeout( getData, 2000);
					
						
						
					}
				})

				
			}
			
			function getCookie(cname) {
			  let name = cname + "=";
			  let ca = document.cookie.split(';');
			  for(let i = 0; i < ca.length; i++) {
			    let c = ca[i];
			    while (c.charAt(0) == ' ') {
			      c = c.substring(1);
			    }
			    if (c.indexOf(name) == 0) {
			      return c.substring(name.length, c.length);
			    }
			  }
			  return "";
			}
			
			

		

			function scrollDown() {
				 chat_log.scrollTop = chat_log.scrollHeight;
			}

			

			getData();


			/*let chatCheck = setTimeout(function(){ //check chat to see if there's anything new 


			},3000)*/
		})
		
	</script>

</body>
</html>