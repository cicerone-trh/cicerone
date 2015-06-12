<?php
	error_reporting(E_ALL);
	ini_set('display_errors',1);

	require_once('includes/db_connect.php');
	require_once('includes/defines.php');

	if (isset($_SESSION['username'])){			// if user is logged in
		// initialize user object
		include('views/home.php');
	} else {								// if user is not logged in
		include('views/default.php');
	}

?>
