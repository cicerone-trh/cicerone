<?php

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	require_once("db_connect.php");
	require_once("../models/activity.php");

	if(isset($_POST['mod_activity'])) {
		// duration to seconds
		$_POST['duration'] = $_POST['duration_m']*60 + $_POST['duration_h']*3600;
		$activity = new Activity($_POST,$conn);
		$activity->saveToDB();
	}
	
	if(isset($_POST['create_account'])){

		$username = $_POST['new_username'];
		$password = $_POST['new_password'];

		$_SESSION['processMessage'] = "";

		$blankEntry = '/\S/';

		// if either username or password is empty (ie they have scripts turned off)
		if (!preg_match($blankEntry, $username) || !preg_match($blankEntry, $password)){
			$_SESSION['processMessage'] .= "Username or Password was empty.<br>";
		} else {

			// check if the username is in use
			$query = "SELECT username FROM cicerone_users WHERE username='$username'";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$_SESSION['processMessage'] .= "That username already exists.<br>";
			} else {

				// if not in use, attempt the insert
				$stmt=$conn->prepare("insert into cicerone_users (username,password) values (?, ?)");
				$stmt->bind_param("ss", $username, $password);
				$stmt->execute();

				$_SESSION['processMessage'] .= "You have been added to the system.";
			}	
		}
	
	}

	if(isset($_POST['add_activity'])) {

		$isValid = true;

		$activityName = $_POST['name'];	
		$hours = $_POST['duration_h'];
		$minutes = $_POST['duration_m'];
		$description = $_POST['description'];
		$project_id = $_POST['project_id'];
		$uriLink = $_POST['uriLink'];
		$types = $_POST['types'];

		// if any required entry is blank

		$blankEntry = '/\S/';
		if (!preg_match($blankEntry, $description) ||
			!preg_match($blankEntry, $activityName) ||
			!preg_match($blankEntry, $hours) && !preg_match($blankEntry, $minutes)
		) {
			echo "A required field was empty";
			exit();
			$isValid = false;
		}
		
		// if number fields are not numbers

		// calculate duration in seconds 

		$duration = $hours * 60 * 60 + $minutes * 60;

		$stmt = $conn->prepare(
			"INSERT INTO cicerone_activities " .
			"(project_id, name, duration, types, description, uriLink, dateCreated)" .
			"VALUES(?,?,?,?,?,?,NOW())"
		);

		$stmt->bind_param("isisss",$project_id, $activityName, $duration, $types, $description, $uriLink);
		
		if ($stmt->execute()) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
	
	}

	if(isset($_POST['add_project'])) {
		$isValid = true;

		$user_id = $_SESSION['user_id'];
		$projectName = $_POST['project'];	
		$description = $_POST['description'];
		$uriLink = $_POST['uriLink'];

		if (isset($_POST['isValue'])){
			$isValue = 1;
		} else {
			$isValue = 0;
		}	
	
		$stmt = $conn->prepare(
			"INSERT INTO cicerone_projects " .
			"(user_id, name, description, isValue, uriLink, dateCreated) " .
			"VALUES(?,?,?,?,?,NOW())"
		);

		$stmt->bind_param("issis", $user_id, $projectName, $description, $isValue, $uriLink);

		if ($stmt->execute()) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}


	header("Location:/",true,303);
	exit();


?>
