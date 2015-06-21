<?php

	require_once("project.php");

	class User {

		private $db;
		private $user_id;
		private $projects;
		private $activities;
		private $url;
		private $totalTime;

		private $listType;


		public function __construct ($id, $db) {
			$this->db = $db;
			$this->user_id = $id;
			$this->activities = array();
			$this->projects = array();
			$this->buildProjectList();
			$this->setTime();

			$this->listType = "default";
		}


		public function getId() {
			return $this->user_id;
		}

		public function getTime() {
			return number_format($this->totalTime/3600,2);
		}

		public function getTimeByProject($project_id) {
			return $this->projects[$project_id]->getTime();
		}

		public function getTimeByDates($dateStart, $dateEnd) {
			$totalTime = 0;
			foreach ($this->projects as $project) {
				$totalTime += $project->getTimeByDates($dateStart, $dateEnd);
			}
			return number_format($totalTime/3600,2);
		}

		// list activities in reverse chronological order
		public function listActivities() {
			if ($this->listType == "project") {

			} else {
				krsort($this->activities);
				foreach ($this->activities as $activity) {
					echo "<div class=\"activity-entry\">";
					echo "<span class=\"activity-date\"> [" . $activity->getMDY() . "] </span>";
					echo "<span class=\"js-link\">" . $activity->getName() . "</span>";

					echo "<span class=\"fr activity-duration\"> (" . $activity->getTimeAsHours() . ") </span>";
					if ($activity->hasLink()) {
						echo "<span class=\"fr\"><a target=\"_new\" href=\"" . $activity->getLink() . "\">Link</a></span>";
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
		}

		public function listActivitiesByProject() {
			foreach ($this->projects as $project) {
				echo "<div data-projectid=\"" . $project->getId() . "\">"; 
				$project->listActivities();
				echo "</div>";
			}
		}

		public function listProjects() {
			foreach ($this->projects as $project) {
				if ($project->hasActivities()) {
					echo "<li data-projectid=\"" . $project->getId() . "\">";
					echo $project->getName();
					echo "</li>\n";
				}
			}
		}

		private function buildProjectList() {
			$sql = "select * from cicerone_projects where user_id = $this->user_id";
			$result = $this->db->query($sql);   	
			while ($row = $result->fetch_assoc()) {
				$this->projects[$row['id']] = new Project($row, $this->db);
				$projectActivities = $this->projects[$row['id']]->getActivities();
				foreach ($projectActivities as $activity) {
					$this->activities[$activity->getId()] = $activity;
				}
			}
		}

		private function setTime() {
			$totalSeconds = 0;

			foreach ($this->projects as $project) {
				$totalSeconds += $project->getTime();
			}
			
			$this->totalTime = $totalSeconds;
		}
	}
?>
