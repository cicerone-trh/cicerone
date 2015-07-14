<?php
	/* *
	 * This page displays a user's history.
	 * */
?>
<?php $document_title = "History"; ?>
<?php include("includes/header.php"); ?>
<?php require_once("../scripts/db_connect.php"); ?>

	<style type="text/css">
		.projectListing {
			width: 100%;
		}

		.projectListing span {
			display:inline-block;
			width: 20%;
		}
		.projectListing .name {
			width: 40%;
		}
		.projectListing .actCount {
			width: 10%;
		}
		.projectListing .hours {
			width: 10%;
		}
	</style>

	<?php 
		// iterate through user's projects
		// now I see how I was so stupid about this :)
		
		$projects = $User->getProjects();

		foreach($projects as $project) {
			if ($project->hasActivities()){ 
				echo '<div class="projectListing">';
				echo '<span class="name">' . $project->getName() . '</span>';
				echo '<span class="hours">' . number_format(($project->getTime()/3600), 2) . '</span>';
				echo '<span class="js-link actCount">' . count($project->getActivities()) . '</span>';
				echo '</div>';
			}
		}
	?>

<?php include("includes/footer.php"); ?>
