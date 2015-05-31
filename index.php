<?php
	require_once("db_connect.php");
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>cicerone</title>
	<link rel="stylesheet" type="text/css" href="css/default.css" />
</head>

<body>
<div class="container">
	<h1>Cicerone - Personal Historian</h1>
	<div class="grid">	
	<div class="unit three-of-four">
		<h2>Add Activity</h2>
		<form method="post" action="process.php">

			<div class="grid">
				<label for="activity" class="unit three-of-five">Activity</label>
				<label for="duration" class="unit two-of-five">Duration</label>
			</div>

			<div class="grid">
				<input class="unit three-of-five" name="activity"  type="text">
				<input class="unit one-of-five" name="duration_h" placeholder='h' type="text">
				<input class="unit one-of-five" name="duration_m" placeholder='m' type="text">
			</div>

			<div class="grid">
				<label for="description" class="unit span-grid">Description</label>
			</div>
			<div class="grid">
				<textarea class="unit span-grid" name="description" type="textfield">
				</textarea>
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

		<!--
			<li>sell things</li>
			<li>get a job</li>
			<li>make em love me</li>
			<li>Strength Training</li>
			<li>vim - ctags</li>
			<li>Game of Traffic</li>
			<li>Blinkenlights</li>
			<li>Nervous Pooper</li>
			<li>Nervous Pooper - Dog</li>
			<li>Lisp</li>
			<li>SmallTalk</li>
			<li>Android Timers</li>
			<li>Dota Blog - from 3k to 4k</li>
			<li>Cherokee</li>
			<li>Failboat Captain - SSS</li>
			<li>Classy Site</li>
		-->
		</ul>
		
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
		<p><a href="project.php">New Project</a></p>
	</span>

	</footer>
</div><!-- end container -->

</body>
</html>
