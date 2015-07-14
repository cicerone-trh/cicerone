<?php
	/* *
	 * This page represents the userspace when they are logged in.
	 * From this page, a user can view and edit their history
	 * */
?>
<?php $document_title = "Home"; ?>
<?php include("includes/header.php"); ?>
<?php require_once("../scripts/db_connect.php"); ?>
<?php require_once("views/lister.php"); 
	$lister = new Lister();
?>

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
	<h2>Projects <img style="width:0.75em;height:0.75em" id="editProjects" alt="Edit" src="/img/edit_project.svg"></h2>
		<ul id="projectList">
			<li data-projectid="0" class="selected">--View All</li>
			<?php $User->listProjects(); ?>
		</ul>
		<div id="projectListControls" class="clickable">
			<span id="editProjectLink" style="display:inline-block; width:49%" class=""></span>
			<span id="showProjectLink" style="display:inline-block; width:49%" class="">List Activities</span>
		</div>

		<p>Total Hours Recorded: <?php echo $User->getTime(); ?><br>
		Today: <?php echo $User->getTimeByDates(strtotime("-24 hours"), time()); ?></p>

		<div id="processMessage">
		<?php 
			if (isset($_SESSION['processMessage'])) {
				echo $_SESSION['processMessage'];
				unset($_SESSION['processMessage']);
			}
		?>
		</div>
		
	</div> <!-- project list -->

	<div class="unit three-of-four">
		<div id="history_header">
			<h2>Activity History: </h2>
			<div id="activityListingControls">
				<span class="hidden js-link" id="lessActivitiesLink">&lt;&lt; Less</span><span class="js-link" id="moreActivitiesLink">More &gt;&gt;</span>
			</div>
			<div class="clear">
			</div>
		</div>
		<div id="history-list">
			<?php if ($lister->echoActivities($User, 0, 15) == false) {
				echo "<p>To get started...</p>";
			} ?>
			<?php // $User->listActivities(); ?>
		</div>
		<div id="edit-form-div" class="hidden">
			<div id="edit-form">
			</div>
			<span id="cancel-edit" class="js-link">Cancel Editing</span>
		</div>
	</div>
</div> 
<div id="add-project" class="form-div hidden">
	<form id="addProject" method="post" action="/includes/process.php">
		<div class="grid">
			<label for="project" class="unit three-of-five">Project</label>
			<label for="isValue" class="unit two-of-five" style="text-align:center;">Active?</label>
		</div>
		<div class="grid">
			<input class="unit three-of-five" name="project"  type="text">
			<span class="unit two-of-five" style="text-align:center">
				<input type="checkbox" name="isActive" checked="checked">
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
			<input class="unit one-of-five" name="add_project" type="submit" value="Submit">
		</div>
		<span class="note">Note: projects need to be active to add activities to them :)</span>
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
			<input class="unit span-grid" name="types" placeholder='Types' type="text">
		</div>

		<div class="grid">
			<select id="projectSelectInput" class="unit span-grid" name="project_id">
		<?php
			$sql = "SELECT name,id FROM cicerone_projects WHERE isActive=1 AND user_id=" . $User->getId();
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<option value =\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";
				}
			} else {
				echo "<option value=\"0\">Create a project to add activities</option>";
			}
		?>
			</select>
		</div>

		<div class="grid">
			<input class="unit four-of-five" name="uriLink" placeholder='Uri' type="text">
			<input class="unit one-of-five" name="add_activity" type="submit" value="Submit">
		</div>
	</form>

</div>
</div><!-- component-container -->


<?php include("includes/footer.php"); ?>
