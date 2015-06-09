<?php
	require_once("includes/db_connect.php");
?>

<!-- RICKETY VERSION THAT I AM USING JUST SO THAT I CAN INPUT ACTIVITIES -->

<!DOCTYPE HTML>
<html>
<head>
	<title>cicerone</title>

	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="css/default.css" />

	<link href='http://fonts.googleapis.com/css?family=Kreon:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Comfortaa:400,300,700' rel='stylesheet' type='text/css'>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="js/main.js"></script>

</head>

<body>
<div class="container">
	<h1>Cicerone</h1>
	<hr>
	<div class="grid">	
	<div class="unit one-of-four">
		<h2>Projects: <span style="font-size:50%">View | Edit</span>	</h2>
			<ul id="project-list">
			<?php
				$sql = "SELECT name FROM cicerone_projects";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo "<li>" . $row['name'] . "</li>\n";
					}
				}
			?>
			</ul>
	</div>

	<div style="border-left: 1px solid #000;padding-left: 20px" class="unit three-of-four">
		<h2>Add Activity</h2>
		<form id="addActivity" method="post" action="includes/process.php">

			<div class="grid">
				<label for="name" class="unit three-of-five">Activity</label>
				<label for="duration" class="unit two-of-five">Duration</label>
			</div>

			<div class="grid">
				<input class="unit three-of-five" name="name" type="text" required>
				<input class="unit one-of-five" name="duration_h" placeholder='h' type="number">
				<input class="unit one-of-five" name="duration_m" placeholder='m' type="number">
			</div>

			<div class="grid">
				<label for="description" class="unit span-grid">Description</label>
			</div>
			<div class="grid">
				<textarea class="unit span-grid" name="description" type="textfield" required></textarea>
			</div>

			<div class="grid">
				<label for="type" class="unit span-grid">Types</label>
			</div>
			<div class="grid">
				<input class="unit span-grid" name="type" placeholder='Types' type="text">
			</div>

			<div class="grid">
				<select class="unit span-grid" name="project_id">
			<?php
				$sql = "SELECT name,id FROM cicerone_projects";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo "<option value =\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";
					}
				}
			?>
				</select>
			</div>

			<div class="grid">
				<input class="unit four-of-five" name="uriLink" placeholder='Uri' type="text">
				<input class="unit one-of-five" name="add-activity" type="submit" value="Submit">
			</div>

		</form>
	</div>

	</div><!-- end grid -->

	<footer class="grid">

	<span class="unit one-of-four">
		<p>
			<a href="project.php">New Project</a> <br />
			<a href="debug.php">Debug</a><br />
			<?php 
				$sql = "SELECT duration, dateCreated FROM cicerone_activities";
				$result = $conn->query($sql);
				$totalSeconds = 0;
				$todaySeconds = 0;

				// for "past 24 hours" feature
				$dayAgo = strtotime("-24 hours");

				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$totalSeconds += $row['duration'];

						if (strtotime($row['dateCreated']) >= $dayAgo) {
							$todaySeconds += $row['duration'];
						}
					}
				}

				$totalHours = $totalSeconds / 60 / 60;
				$todayHours = $todaySeconds / 60 / 60;

				echo "<p>Total Hours Recorded: "; 
				echo number_format($totalHours, 2);
				echo "<br>Today: ";
				echo number_format($todayHours, 2);
				echo "</p>";
			?>
			</p>
		</span>
		<span class="unit three-of-four">
		</span>
	</footer>
</div><!-- end container -->
</body>
</html>

