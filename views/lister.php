<?php
/* The point of this class is to group functionality that generates displays/lists of objects.
 * */


class Lister {

	// retrieve and list # of activities
	// retrieve # of projects
	// here, we have a use case for an interface: listable

	public function setSort() {

	}

	public function echoControls() {
		echo '<div id="listControls">';
		echo '</div>';
	}
	
	public function echoActivities($listable, $offset, $count) {

		// get list of activities from the scope; user/project
		$full = $listable->getActivities();
		$activities = array_slice($full, $offset, $count);

		// display activities if they exist 
		if (count($activities) > 0) {
			foreach ($activities as $activity) {
				$this->echoActivity($activity);
			}

			// this solution is probably bad, but I'm having fun;
			// span with data-attributes to pass to JS controls
			
			$dataMore = 0;
			$dataLess = $offset - $count;

			if (count($full) > $offset + $count) {
				$dataMore = $offset + $count;
			}

			echo '<span class="hidden" id="listData" ' . 
				' data-more="' . $dataMore . '"' . 
				' data-less="' . $dataLess . '"' .
				'">';
			echo '</span>';
			return true;

		// display case where no activities are found and return false
		} else {
			echo "<p>To get started, add a project.</p><p>Then add an activity to that project.</p> <p>And then the world is your's &#94;&#95;&#94;</p>";

			$dataMore = 0;
			$dataLess = -15;

			echo '<span class="hidden" id="listData" ' . 
				' data-more="' . $dataMore . '"' . 
				' data-less="' . $dataLess . '"' .
				'">';
			echo '</span>';
			return false;
		}
	}

	public function echoActivity($activity) {
		echo "<div class=\"activity-entry\">";
		echo "<span class=\"activity-date\"> [" . $activity->getMDY() . "] </span>";
		echo "<span class=\"js-link\">" . $activity->getName() . "</span>";

		echo "<span class=\"fr activity-duration\"> (" . $activity->getTimeAsHours() . ") </span>";
		if ($activity->hasLink()) {
			echo "<span class=\"fr\"><a target=\"_blank\" href=\"" . $activity->getLink() . "\">Link</a></span>";
		}
		echo "<span data-id=\"" . $activity->getId() . "\"" . "class=\"icons hidden\">";
		echo "<img class=\"e-icon\" src=\"/img/edit.svg\" alt=\"Edit\"/>";
		echo "<img class=\"d-icon\" src=\"/img/delete_2.svg\" alt=\"Delete\"/>";
		echo "</span>";
		echo "<div class=\"activity-description hidden\">";
		echo $activity->getDesc();
		echo "<br>";
		echo "<div class=\"clear\"></div>";
		echo "</div>";
		echo "</div>";
	}

	public function echoProjects($listable) {
		
		$projects = $listable->getProjects();

		// sort projects
		$active = array();
		$inactive = array();
		foreach ($projects as $project) {
			$offset = 0;

			if ($project->isActive()) {
				if (isset($active[$project->getTime()])) {
					$offset = $project->getId();
				}
				$active[$project->getTime() + $offset] = $project;

			} else {
				if (isset($inactive[$project->getTime()])) {
					$offset = $project->getId();
				}
				$inactive[$project->getTime() + $offset] = $project;
			}
		}			

		krsort($active);
		krsort($inactive);

		// display heading

		echo '<div class="projectDetails">';
		echo '<span class="projectTime">Hours</span>';
		echo '<span>Name</span>';
		echo '<span class="activeProject">Active?</span>';
		echo '</div>';

		// display projects
		foreach ($active as $project) {
			$this->echoProject($project);
		}

		foreach ($inactive as $project) {
			$this->echoProject($project);
		}
	}

	public function echoProjectsSimple($listable) {
		$projects = $listable->getProjects();
		foreach ($projects as $project) {
			if ($project->hasActivities()) {
				echo "<li data-projectid=\"" . $project->getId() . "\">";
				echo $project->getName();
				echo "</li>\n";
			}
		}
	}	

	public function echoProject($project) {
		echo '<div class="projectDetails">' . "\n";
			echo '<span class="projectTime">' . number_format($project->getTime() / 3600, 2) . '</span>';
			echo '<span class="js-link">' . $project->getName(). '</span>';
			echo "<span data-id=\"" . $project->getId() . "\"" . "class=\"icons hidden\">";
			echo "<img class=\"e-icon\" src=\"/img/edit.svg\" alt=\"Edit\"/>";
			if (!$project->hasActivities()) {
				echo "<img class=\"d-icon\" src=\"/img/delete_2.svg\" alt=\"Delete\"/>";
			}
			echo "</span>";
			echo '<span class="activeProject">';
				echo '<input data-id=' . $project->getId() . ' type="checkbox" ' . (($project->isActive()) ? "checked" : "") . '>';
			echo '</span>';
			echo '<div class="activity-description hidden">';
			echo $project->getDescription();
			echo '</div>';
		echo "</div>";
	}
}

?>
