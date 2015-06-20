<?php
	error_reporting(E_ALL);
	ini_set('display_errors',1);

	require_once("../includes/db_connect.php");
	require_once("../models/activity.php");

	$user_id = $_SESSION['user_id'];
	$actId = $_GET['id'];

	// build activity from id
	$activity = new Activity($actId,$conn);
	$activity->deleteActivity($user_id);
	
	header("Location: ../",true,303);
	exit();
?>
