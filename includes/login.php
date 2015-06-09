<?php

//	require_once("db_connect.php");

	session_start();

	$_SESSION['user'] = 'lol';


	header("Location:../new_index.php",true,303);
	exit();

?>
