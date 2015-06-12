<?php
	/* *
	 * This page represents the userspace when they are logged in.
	 * From this page, a user can view and edit their history
	 * */
?>

<?php include(CIC_HEADER); ?>
<?php require_once( CIC_ROOT . "/includes/db_connect.php"); ?>

<div class="content-header">
	<ul>
		<li><span data-order="1" id="view-history-link" class="js-link activeLink">View History</span></li>
		<li><span data-order="2" id="add-project-link" class="js-link">Add Project</span></li>
		<li><span data-order="3" id="add-activity-link" class="js-link">Add Activity</span></li>
		<li><a href="/includes/logout.php">logout</a></li>
	</ul>
</div>
<div class="component-container">
<div class="grid active-component" id="view-history">
	<div class="unit one-of-four">
	<h2>Projects:</h2>
		<ul id="project-list">
		<?php
			$user_id = $_SESSION['user_id'];
			$sql = "SELECT name FROM cicerone_projects WHERE user_id = $user_id";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<li>" . $row['name'] . "</li>\n";
				}
			}
		?>
		</ul>
		<?php // displaying hours done
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
	</div> <!-- project list -->
	<div class="unit three-of-four">
	<h2>Item Details</h2>
	</div>

</div> 
<div id="add-project" class="form-div hidden">
	<form method="post" action="/includes/process.php">
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
			<textarea class="unit span-grid" name="description" type="textfield"></textarea>
		</div>
		<div class="grid">
			<input class="unit four-of-five" name="uriLink" placeholder='Uri' type="text">
			<input class="unit one-of-five" name="add-project" type="submit" value="Submit">
		</div>
	</form>
</div>
<div id="add-activity" class="form-div hidden">
	<form id="addActivity" method="post" action="/includes/process.php">

		<div class="grid">
			<label for="name" class="unit three-of-five">Activity</label>
			<label for="duration" class="unit two-of-five">Duration</label>
		</div>

		<div class="grid">
			<input class="unit three-of-five" name="name" type="text" required>
			<input class="unit one-of-five" name="duration_h" placeholder='h' type="">
			<input class="unit one-of-five" name="duration_m" placeholder='m' type="">
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
			$sql = "SELECT name,id FROM cicerone_projects WHERE user_id=$user_id";
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
</div><!-- component-container -->


<?php include(CIC_FOOTER); ?>
