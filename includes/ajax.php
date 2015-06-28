<?php

	// ajax.php?act=""&arg1=""	

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	require_once("../models/project.php");
	require_once("../models/user.php");
	require_once("../../scripts/db_connect.php");

	if (isset($_GET['act'])){

		// request to load project
		if ($_GET['act'] == "loadProject" ){
			if ($_GET['id'] == 0) {
				$user = new User($_SESSION['user_id'], $conn);
				$user->listActivities();
			} else {
				$project = new Project($_GET['id'],$conn);
				$project->listActivities();
			}
			exit();

		// request to get activities starting at certain index
		} else if ($_GET['act'] == "getActs") {
			if (isset($_GET['i'])) {
				// user->getActivities($_GET['i'], 20); 
			}
		}
	
	// not a valid GET request
	} else {
		echo "faulty request";
	}
?>
