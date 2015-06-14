<?php
	error_reporting(E_ALL);
	ini_set('display_errors',1);

	require_once('includes/db_connect.php');
	require_once('includes/defines.php');
	require_once('models/user.php');

	$now = time();

	if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
		// will still process your form entry, but you will be logged out
		session_unset();
		session_destroy();
		session_start();
	}

	if (isset($_SESSION['user_id'])){			// if user is logged in
		$User = new User($_SESSION['user_id'], $conn);
		include('views/home.php');
	} else {									// if user is not logged in
		include('views/default.php');
	}

?>
