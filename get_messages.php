<?php 

 // $db = new SQLite3(getcwd().'/databases/chat.db');
  //$db = new SQLite3('/web/alh8007/webdev/macro_assignment_09/databases/chat.db');
  include('config.php');

  $username = $_POST['username'];
  

  //grab all messages from db
  $sql = "SELECT * FROM chats";
  //$sql = "SELECT * FROM chats WHERE roomid = "
  $results = $db->query($sql);
  $now = time();

  $sql_ping = "UPDATE pings SET time = $now WHERE username = '{$username}'";
  $db->query($sql_ping);

  $return_array = array();
  $return_array['chat'] = array();
  $return_array['pings'] = array();

  while ($row = $results->fetchArray()){
  	$result_array = array();
  	$result_array['id']=$row['id'];
  	$result_array['name']=$row['name'];
  	$result_array['message']=htmlspecialchars_decode(stripslashes($row['message']));


  	array_push($return_array['chat'], $result_array);
  }

  $recentTime = $now-15;
  $sql_userlist = "SELECT * FROM pings WHERE time >= $recentTime";
  $userResults = $db->query($sql_userlist);
  while($row = $userResults -> fetchArray()){
    $result_array = array();
    $result_array['username']=$row['username'];

    array_push($return_array['pings'], $result_array);
  }

  print json_encode($return_array);
  //package up and sent to client


  exit();

?>