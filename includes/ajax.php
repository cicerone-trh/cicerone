<?php

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
		} else if ($_GET['act'] == "editActivity") {
			exit();
		} else {
			exit();
		}

	} else {
		echo "faulty request";
	}
?>
