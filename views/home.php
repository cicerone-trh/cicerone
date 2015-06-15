<?php
	/* *
	 * This page represents the userspace when they are logged in.
	 * From this page, a user can view and edit their history
	 * */
?>
<?php $document_title = "Home"; ?>
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
			<li>--View All</li>
			<?php $User->listProjects(); ?>
		</ul>
		<div id="project-list-controls" class="grid">
			<span id="show-project-link" class="unit one-of-two">View</span><span id="edit-project-link" class="unit one-of-two">Edit</span>
		</div>

		<p>Total Hours Recorded: <?php echo $User->getTime(); ?><br>
		Today: <?php echo $User->getTimeByDates(strtotime("-24 hours"), time()); ?></p>
	</div> <!-- project list -->
	<div class="unit three-of-four">
	<h2>History</h2>
		<ul id="history-list">
			<?php $User->listActivities(); ?>
		</ul>
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
			$sql = "SELECT name,id FROM cicerone_projects WHERE user_id=" . $User->getId();
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
