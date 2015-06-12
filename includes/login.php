<?php

	require_once("db_connect.php");

	if (isset($_POST['username']) && isset($_POST['password'])) {
		// password security: sha1 + ? I am going to revisit 
		$username = $_POST['username'];
		$password = $_POST['password']; // sha1?

		$stmt = $conn->prepare("select id, username from cicerone_users where username=? and password=?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$stmt->bind_result($user_id, $name);


		if ($stmt->fetch()) {
			// should this initialize an object? how does one do that with client/s?
			$_SESSION['username'] = $name;
			$_SESSION['user_id'] = $user_id;
		} else {
			$error = "could not find user, pw";
		}

		$stmt->close();
	} 

	header("Location: /" ,true,303);
	exit();

?>
