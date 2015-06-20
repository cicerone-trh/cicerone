<?php
	require_once("db_connect.php");
	require_once("../models/activity.php");

	if (isset($_GET['id'])){
		$activity = new Activity($_GET['id'],$conn);
		echo json_encode($activity->asArray);
	} else {
		echo "lol";
	}
?>
