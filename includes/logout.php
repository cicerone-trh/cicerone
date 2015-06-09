<?php
	session_start();
	session_destroy();
	header("location:../new_index.php");
?>
