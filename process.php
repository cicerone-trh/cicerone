<?php

	require_once("db_connect.php");

	if(isset($_POST['add-activity'])) {
		$activity = $_POST['activity'];	
		$hours = $_POST['duration_h'];
		$minutes = $_POST['duration_m'];
		$description = $_POST['description'];
		$uriLink = $_POST['uriLink'];

		$duration = $hours * 60 * 60 + $minutes * 60;

		$sql = "INSERT INTO cicerone_activities ".
       		"(activity,duration,description,uriLink,dateCreated) ".
       		"VALUES('$activity',$duration,'$description','$uriLink',NOW())";		

		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	if(isset($_POST['add-project'])) {

		$project = $_POST['project'];	
		$description = $_POST['description'];
		$uriLink = $_POST['uriLink'];
		$project_id = $_POST['project_id'];

		if (isset($_POST['isValue'])){
			$isValue = 1;
		} else {
			$isValue = 0;
		}	
		
		$sql = "INSERT INTO cicerone_projects ".
       		"(project_id,name,description,isValue,uriLink,dateCreated) ".
       		"VALUES($project_id,'$project','$description',$isValue,'$uriLink',NOW())";		

		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	header("Location:index.php",true,303);
	exit();
	
?>
