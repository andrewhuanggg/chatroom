<?php 
	if($_COOKIE['PHPSESSID']) {
		session_start();
		setcookie( session_name(), "", time()-3600, "/" );

	    //clear session from globals
	    session_unset();

	    // just to be safe, delete the session superglobal as well
	    $_SESSION = array();

	    // clear session from server
	    session_destroy();

	    header('Location: index.php');
	}


?>