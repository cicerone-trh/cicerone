<?php

	require_once("../../scripts/db_connect.php");

	if (isset($_POST['username']) && isset($_POST['password'])) {
		$username = $_POST['username'];
		$password = $_POST['password']; 

		$stmt = $conn->prepare("select id, username, password from cicerone_users where username=?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($user_id, $name, $pass_hash);

		if ($stmt->fetch()) {
			if (password_verify($password, $pass_hash)) {
				$_SESSION['username'] = $name;
				$_SESSION['user_id'] = $user_id;
				$_SESSION['discard_after'] = time() + 100000;		// logged in for 10 seconds
			} else {
				$_SESSION['processMessage'] = "Matching credentials not found.";
			}
		} else {
			$_SESSION['processMessage'] = "Matching credentials not found.";
		}

		$stmt->close();
	} 

	header("Location: /" ,true,303);
	exit();

?>
