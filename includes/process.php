<?php

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	require_once("../../scripts/db_connect.php");
	require_once("../models/activity.php");
	require_once("../models/project.php");

	if(isset($_GET['delproj'])) {
		$project = new Project($_GET['delproj'], $conn);
		$project->deleteProject();
	}

	if(isset($_POST['mod_project'])) {
		$isValid = true;
		
		$hasValue = '/\S/';

		if (!preg_match($hasValue, $_POST['description']) || !preg_match($hasValue, $_POST['project'])) {
			$_SESSION['processMessage'] = "A required field was empty: " . $_POST['description'] . $_POST['project'];
			$isValid = false;
		}

		if ($isValid) {
			// hacking array values
			$_POST['name'] = $_POST['project'];
			if (isset($_POST['isActive'])){
				$_POST['isActive'] = 1;
			} else {
				$_POST['isActive'] = 0;
			}	

			$project = new Project($_POST,$conn);
			$success = $project->saveToDB();

			if ($success == true) { 
				$_SESSION['processMessage'] = "Project updated!";
			} else {
				$_SESSION['processMessage'] = "Unable to update project!";
			}
		}

	}

	if(isset($_POST['mod_activity'])) {
		// validate input
		$isValid = true;
		
		$hasValue = '/\S/';
		$nonNum = '/\D/';

		// if either number field was non numeric
		if (preg_match($nonNum, $_POST['duration_h']) || preg_match($nonNum, $_POST['duration_m'])) {
			$_SESSION['processMessage'] = "A duration field was non-numeric.";
			$isValid = false;
		}

		// if any required fields are blank
		if (!preg_match($hasValue, $_POST['description']) || !preg_match($hasValue, $_POST['name'])) {
			$_SESSION['processMessage'] = "A required field was empty";
			$isValid = false;
		}

		if ($isValid) {
			$_POST['duration'] = $_POST['duration_m']*60 + $_POST['duration_h']*3600;

			$activity = new Activity($_POST,$conn);
			$success = $activity->saveToDB();

			if ($success == true) { 
				$_SESSION['processMessage'] = "Activity updated!";
			} else {
				$_SESSION['processMessage'] = "Unable to update activity!";
			}
		}
	}
	
	if(isset($_POST['create_account'])){

		$username = $_POST['new_username'];
		$password = $_POST['new_password'];

		$_SESSION['processMessage'] = "";

		$blankEntry = '/\S/';

		// if either username or password is empty (ie they have scripts turned off)
		if (!preg_match($blankEntry, $username) || !preg_match($blankEntry, $password)){
			$_SESSION['processMessage'] .= "Username or Password was empty.<br>";
		// if they didn't enter bot message
		} else if ($_POST['turing_test']!="please") {
	   		$_SESSION['processMessage'] .= "You didn't say please. I understand :(";
		// if passwords do not match
		} else if ($_POST["new_password"] != $_POST["confirm_password"]) {
			$_SESSION['processMessage'] .= "The two passwords did not match!";
		} else {

			// check if the username is in use
			$query = "SELECT username FROM cicerone_users WHERE username='$username'";
			$result = $conn->query($query);
			if ($result->num_rows > 0) {
				$_SESSION['processMessage'] .= "That username already exists.<br>";
			} else {

				$password = password_hash($password, PASSWORD_DEFAULT);

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

		$hasValue = '/\S/';
		$nonNum = '/\D/';

		$_SESSION['processMessage'] = "";

		if ($project_id == 0) {
			$_SESSION['processMessage'] .= "Must select a project to add activity to!";
			$isValid = false;
		}

		// if either number field was non numeric
		if (preg_match($nonNum, $hours) || preg_match($nonNum, $minutes)) {
			$_SESSION['processMessage'] .= "A duration field was non-numeric.";
			$isValid = false;
		}

		// if any required fields are blank
		if (!preg_match($hasValue, $description) ||
			!preg_match($hasValue, $activityName) ||
			!preg_match($hasValue, $hours) && !preg_match($hasValue, $minutes)
		) {
			$_SESSION['processMessage'] .= "A required field was empty";
			$isValid = false;
		}
		
		if ($isValid) {
			$duration = $hours * 60 * 60 + $minutes * 60;

			$stmt = $conn->prepare(
				"INSERT INTO cicerone_activities " .
				"(project_id, name, duration, types, description, uriLink, dateCreated)" .
				"VALUES(?,?,?,?,?,?,NOW())"
			);

			$stmt->bind_param("isisss",$project_id, $activityName, $duration, $types, $description, $uriLink);
			
			if ($stmt->execute()) {
				$_SESSION['processMessage'] .= "Activity added!";
			} else {
				$_SESSION['processMessage'] .= "Error: " . $sql . "<br>" . $conn->error;
			}
		}	
	
	}

	if(isset($_POST['add_project'])) {
		$isValid = true;

		$user_id = $_SESSION['user_id'];
		$projectName = $_POST['project'];	
		$description = $_POST['description'];
		$uriLink = $_POST['uriLink'];

		if (isset($_POST['isActive'])){
			$isValue = 1;
		} else {
			$isValue = 0;
		}	
	
		$stmt = $conn->prepare(
			"INSERT INTO cicerone_projects " .
			"(user_id, name, description, isActive, uriLink, dateCreated) " .
			"VALUES(?,?,?,?,?,NOW())"
		);

		$stmt->bind_param("issis", $user_id, $projectName, $description, $isValue, $uriLink);

		if ($stmt->execute()) {
			$_SESSION['processMessage'] = "New project added!";
		} else {
			$_SESSION['processMessage'] = "Error: " . $sql . "<br>" . $conn->error;
		}
	}


	header("Location:/",true,303);
	exit();

?>
