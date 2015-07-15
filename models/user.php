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

		public function getActivities() {
			krsort($this->activities);
			return $this->activities;
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
