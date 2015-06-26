<?php
	/* *
	 * This page displays a user's history.
	 * */
?>
<?php $document_title = "User View"; ?>
<?php include("includes/header.php"); ?>
<?php require_once("../scripts/db_connect.php"); ?>

<?php
	
	// okay so the plan is to get the id,
	// check if the id exists
	// check if it is public
	// and then if it is create a user object
	// then use that user object to display shit
?>


<?php include("includes/footer.php"); ?>
