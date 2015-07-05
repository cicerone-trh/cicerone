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

		public function getProjects() {
			return $this->projects;
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
			if (count($this->activities) > 0) {
				krsort($this->activities);
				foreach ($this->activities as $activity) {
					$activity->displaySelf();
				}
			} else {
				echo "<p>To get started, add a project.</p><p>Then add an activity to that project.</p> <p>And then the world is your's &#94;&#95;&#94;</p>";
			}
		}

		public function listActivitiesByProject() {
			foreach ($this->projects as $project) {
				echo "<div data-projectid=\"" . $project->getId() . "\">"; 
				$project->listActivities();
				echo "</div>";
			}
		}

		public function listProjects($toEdit = false) {

			// listing to edit
			if ($toEdit) {

				// sort projects
				$active = array();
				$inactive = array();
				foreach ($this->projects as $project) {
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
					$project->listSelf($toEdit);
				}

				foreach ($inactive as $project) {
					$project->listSelf($toEdit);
				}

			// just listing
			} else {
				foreach ($this->projects as $project) {
					if ($project->hasActivities()) {
						echo "<li data-projectid=\"" . $project->getId() . "\">";
						echo $project->getName();
						echo "</li>\n";
					}
				}
			}
		}

		private function buildProjectList() {
			$sql = "select * from cicerone_projects where user_id = $this->user_id";
			$result = $this->db->query($sql);
			if (!$result) {
				echo "something went wrong: ";
				echo $this->db->errno;
			} else {	
				while ($row = $result->fetch_assoc()) {
					$this->projects[$row['id']] = new Project($row, $this->db);
					$projectActivities = $this->projects[$row['id']]->getActivities();
					foreach ($projectActivities as $activity) {
						$this->activities[$activity->getId()] = $activity;
					}
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
