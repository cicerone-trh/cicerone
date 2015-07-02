<?php

	// ajax.php?act=""&arg1=""	

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	require_once("../models/project.php");
	require_once("../models/user.php");
	require_once("../../scripts/db_connect.php");

	if (isset($_GET['act']) && isset($_SESSION['user_id'])){

		// retrieve list of projects for editing
		if ($_GET['act'] == "editProjects") {
			$user = new User($_SESSION['user_id'],$conn);
			$user->listProjects(true);

		// retrieve project as html item
		} else if ($_GET['act'] == "loadProject" && isset($_GET['id'])){
			// id == 0 is "view all"
			if ($_GET['id'] == 0) {
				$user = new User($_SESSION['user_id'], $conn);
				$user->listActivities();
			} else {
				$project = new Project($_GET['id'],$conn);
				$project->listActivities();
			}

		// toggle whether a project is active
		} else if ($_GET['act'] == "toggleActive" && isset($_GET['id'])) {
			$project = new Project($_GET['id'],$conn);
			$project->toggleActive();

		} else if ($_GET['act'] == "echoProject" && isset($_GET['id'])){
			$project = new Project($_GET['id'],$conn);
			echo json_encode($project->asArray);

		// retrieve list of activities starting at certain index
		} else if ($_GET['act'] == "getActs") {
			if (isset($_GET['i'])) {
				// user->getActivities($_GET['i'], 20); 
			}
		}
	
	// not a valid GET request
	} else {
		$_SESSION['processMessage'] = "faulty request";
	}
?>
