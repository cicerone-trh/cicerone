<?php
	// connect to database --- this will be a separate file eventually
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cicerone";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

?>
