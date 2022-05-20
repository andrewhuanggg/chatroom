<?php 
  //$db = new SQLite3(getcwd().'/databases/chat.db');
  //$db = new SQLite3('/web/alh8007/webdev/macro_assignment_09/databases/chat.db');
  include('config.php');
  $sql = "SELECT * FROM visitors";
  $results = $db->query($sql);

  $return_array = array();
  date_default_timezone_set('America/New_York');
  while ($row = $results->fetchArray()){
  	$result_array = array();
  	$result_array['id']=$row['id'];
  	$result_array['ip']=$row['ip'];
  	$result_array['username']=$row['username'];
    $pretty_time = date("F j, Y, g:i a", $row['time']);
  	//$result_array['time']=$row['time'];
    $result_array['time']=$pretty_time;

  	array_push($return_array, $result_array);
  }

  print json_encode($return_array);
  //package up and sent to client


  exit();

?>