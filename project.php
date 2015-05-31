<?php
	require_once("db_connect.php");
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>cicerone - project</title>
	<link rel="stylesheet" type="text/css" href="css/default.css" />
</head>

<body>
<div class="container">
	<h1>Cicerone - Personal Historian</h1>
	<div class="grid">	
	<div class="unit three-of-four">
		<h2>Add Project</h2>
		<form method="post" action="process.php">

			<div class="grid">
				<label for="project" class="unit three-of-five">Project</label>
				<span class="unit two-of-five">
				</span>
			</div>

			<div class="grid">
				<input class="unit three-of-five" name="project"  type="text">
				<span class="unit one-of-five">
 					Valuable?
				</span>
				<span class="unit one-of-five">
					<input type="checkbox" name="isValue">
				</span>
			</div>

			<div class="grid">
				<label for="description" class="unit span-grid">Description</label>
			</div>
			<div class="grid">
				<textarea class="unit span-grid" name="description" type="textfield">
				</textarea>
			</div>

			<div class="grid">
				<input class="unit four-of-five" name="uriLink" placeholder='Uri' type="text">
				<input class="unit one-of-five" name="add-project" type="submit" value="Submit">
			</div>

		</form>
	</div>
	<div class="unit one-of-four">
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
		<!-- filler -->
	</span>

	</footer>
</div><!-- end container -->

</body>
</html>
