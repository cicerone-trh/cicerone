<?php

	require_once("db_connect.php");

	if(isset($_POST['add-activity'])) {

		$isValid = true;

		$activityName = $_POST['name'];	
		$hours = $_POST['duration_h'];
		$minutes = $_POST['duration_m'];
		$description = $_POST['description'];
		$project_id = $_POST['project_id'];
		$uriLink = $_POST['uriLink'];
		$types = $_POST['type'];

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

	if(isset($_POST['add-project'])) {
		$isValid = true;

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
			"(name, description, isValue, uriLink, dateCreated) " .
			"VALUES(?,?,?,?,NOW())"
		);

		$stmt->bind_param("ssis", $projectName, $description, $isValue, $uriLink);

		if ($stmt->execute()) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}


	header("Location:index.php",true,303);
	exit();


?>
