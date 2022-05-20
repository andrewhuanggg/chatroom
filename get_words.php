<?php 

	 //$db = new SQLite3(getcwd().'/databases/chat.db');
	 //$db = new SQLite3('/web/alh8007/webdev/macro_assignment_09/databases/chat.db');
	 include('config.php');

	  //grab all messages from db
	  $sql = "SELECT * FROM badwords";
	  //$sql = "SELECT * FROM chats WHERE roomid = "
	  $results = $db->query($sql);

	  $return_array = array();
	  while ($row = $results->fetchArray()){
		  $result_array = array();
		  $result_array['id']=$row['id'];
		  $result_array['word']=$row['word'];

		  array_push($return_array, $result_array);
	  }

	  print json_encode($return_array);
	  //package up and sent to client


	  exit();


?>