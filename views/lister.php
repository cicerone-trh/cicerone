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
			echo "<p>No activities found!</p>";
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
}

?>
