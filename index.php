<?php
	error_reporting(E_ALL);
	ini_set('display_errors',1);

	require_once('includes/defines.php');
	require_once('../scripts/db_connect.php');
	require_once('models/user.php');

	$now = time();

	if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
		// will still process your form entry, but you will be logged out
		session_unset();
		session_destroy();
		session_start();
	}

	// request to view a public history
	if (count($_GET) === 1 && isset($_GET['user'])){

		// viewable will determine if the user is public or if they are using a valid key
		// perhaps before serving the full page, there is a minor password-esque cypher
		// that has to be verified.

		// $viewable = true;

		$stmt = $conn->prepare("SELECT id from cicerone_users WHERE public_url=?");
		$stmt->bind_param("s", $_GET['user']);
		$stmt->execute();
		$stmt->bind_result($user_id);

		if ($stmt->fetch()) {
			$stmt->free_result(); // okay I have f'd this up now.
			$User = new User($user_id, $conn);
			include('views/view.php');
		} else {
			include('views/private.php');
		}

	
	// logging in/editing of history
	} else {
		if (isset($_SESSION['user_id'])){			// if user is logged in
			$User = new User($_SESSION['user_id'], $conn);
			include('views/home.php');
		} else {									// if user is not logged in
			include('views/default.php');
		}
	}

?>
