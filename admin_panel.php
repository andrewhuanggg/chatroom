<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Admin Panel</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<style type="text/css">
		.hidden {
			display: none;
		}

		#wordlist {
			display: block;
			width: 500px;
			height: 300px;
		}

		/*#admin_panel {
			width: 700px;
			height: auto;
			border: 1px solid black;
			float: left;
		}*/
		#usage_log {
			width: 500px;
			height: auto;
			border: 1px solid black;
			float: left;
		}
	</style>
</head>
<body>
	<h2>Admin Panel</h2>
<div id="adminval"></div>
<div id="loginpage">
Username: <input type="text" id="adminuser"> <br><br>
Password: <input type="text" id="adminpass">
<input type="submit" id="admin_login">
</div>

<div id="admin_panel" class="hidden">
	
	<h3>Banned Words List</h3>
	<div id="wordvalidation"></div>
	Add new word: <input type='text' id='addWord'> <button id="button_addWord">Add</button><br>
	Remove word: <input type='text' id='removeWord'> <button id="button_removeWord">Remove</button><br>
	
	<textarea readonly id="wordlist">
	</textarea>

</div>

<div id="usage_log" class="hidden">
	<h3>Usage Logs</h3>
	<textarea readonly id="visitlist"></textarea>
	
</div>

<script type="text/javascript">
	$(document).ready(function(){
		let adminuser = document.getElementById('adminuser')
		let adminpass = document.getElementById('adminpass')
		let admin_login = document.getElementById('admin_login')
		let admin_panel = document.getElementById('admin_panel')
		let adminval = document.getElementById('adminval')
		let loginpage = document.getElementById('loginpage')
		let removeWord = document.getElementById('removeWord')
		let button_removeWord = document.getElementById('button_removeWord')
		let addWord = document.getElementById('addWord')
		let button_addWord = document.getElementById('button_addWord')
		let wordvalidation = document.getElementById('wordvalidation')
		let usage_log = document.getElementById('usage_log')
		let wordlist = document.getElementById('wordlist')
		let visitlist = document.getElementById('visitlist')
		admin_login.addEventListener('click', function(){
			$.ajax({
				url: 'admin_login.php',
				type: 'post',
				data: {
					username: adminuser.value,
					password: adminpass.value
				},
				success: function(data, status){
					if(data=='success'){
						admin_panel.classList.remove('hidden')
						usage_log.classList.remove('hidden')
						adminval.innerHTML=""
						loginpage.classList.add('hidden')
						
					}
					else if(data=='empty'){
						adminval.innerHTML = "Please fill in all fields!"
					}
					else if(data == 'unsuccessful'){
						adminval.innerHTML = 'Username or password is incorrect.'
					}
				}
			})
		})

		button_removeWord.addEventListener('click',function(){
			$.ajax({
				url: 'remove_words.php',
				type: 'post',
				data: {
					word: removeWord.value
				},
				success: function(data, status){
					if(data == 'success'){
						wordvalidation.innerHTML = "Word successfully removed!"

					}
					else {
						wordvalidation.innerHTML = "Invalid word. Please try again."
					}
				}
			})
		})

		button_addWord.addEventListener('click',function(){
			$.ajax({
				url: 'save_words.php',
				type: 'post',
				data: {
					word: addWord.value
				},
				success: function(data, status){
					if(data == 'success'){
						wordvalidation.innerHTML = "Word successfully added!"

					}
					else {
						wordvalidation.innerHTML = "Invalid word. Please try again."
					}
				}
			})

		});	

		function getWords(){
			$.ajax({
				url: 'get_words.php',
				success: function(data,status) {
					let parsed = JSON.parse(data);
					let newWordlist = '';
					for(let i = 0; i < parsed.length; i++){
							newWordlist += parsed[i].word + "\n";

					}
					wordlist.value = newWordlist;
					setTimeout(getWords, 1000);

				}
			})

		}
		getWords();

		function getVisitors(){
			$.ajax({
				url: 'get_visitors.php',
				success: function(data,status) {
					let parsed = JSON.parse(data);
					let newVisitlist = '';
					for(let i = 0; i < parsed.length; i++){
							
							newVisitlist += 'username: '+ parsed[i].username + '|' + ' last login: '+ parsed[i].time + '|'+ ' IP Address: '+parsed[i].ip + "\n";
							


					}
					visitlist.value = newVisitlist;
					setTimeout(getVisitors, 1000);

				}
			})
		}
		getVisitors();

			
	});
		
		
	
</script>
</body>
</html>