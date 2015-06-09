<?php
	require_once("db_connect.php");
	
	// setting up database objects to use in body
	$projectNames; 		
	$projectDetails; 
	$projectActivities; 

	// projectDetails select * from cicerone_projects where id="x"
	// projectActivities select * from cicerone_activities where project_id="x"

	// listing of projects should have active ones first, and then alphabetical
	// active being defined by "having been worked on in the past three months"
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>cicerone</title>
	<link rel="stylesheet" type="text/css" href="css/default.css" />
</head>

<body>

<div class="container">

<?php require_once("header.php") ?>

	<div class="grid">	

	<div class="unit one-of-four">
		<h2>Projects</h2>
		<ul>
			<?php
				$sql = "SELECT name FROM cicerone_projects";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo "<li>" . $row['name'] . "</li>\n";
					}
				}
			?>
<input type="button" value="View">
		</ul>

	</div>
	<div class="unit three-of-four">
		<h2>History</h2>
	</div>
		
	</div><!-- end grid -->

	<footer class="grid">

	<span class="unit three-of-four">
	<?php 
		$sql = "SELECT duration FROM cicerone_activities";
		$result = $conn->query($sql);
		$totalSeconds = 0;

		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$totalSeconds += $row['duration'];
			}
		}

		$totalHours = $totalSeconds / 60 / 60;

		echo "<p>Total Hours Recorded: "; 
		echo number_format($totalHours, 2);
		/*
		echo "<br>";
		echo "Target: 75.00";
		echo "Earned: $";
		echo number_format($totalHours*25,2);
		*/
		echo "</p>";
	?>
	</span>

	<span class="unit one-of-four">
	</span>

	</footer>
</div><!-- end container -->

</body>
</html>
