<?php

	require_once("project.php");

	class User {

		private $db;
		private $user_id;
		private $projects;
		private $url;
		private $totalTime;


		public function __construct ($id, $db) {
			$this->db = $db;
			$this->user_id = $id;
			$this->projects = array();
			$this->buildProjectList();
			$this->setTime();
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

		public function listActivities() {
			foreach ($this->projects as $project) {
				echo "<div data-projectid=\"" . $project->getId() . "\">"; 
				$project->listActivities();
				echo "</div>";
			}
		}

		public function listProjects() {
			echo "<ul>";
			
			foreach ($this->projects as $project) {
				echo "<li>";
				echo $project->getName();
				echo "</li>\n";
			}
			
			echo "</ul>\n";
		}

		private function buildProjectList() {
			$sql = "select * from cicerone_projects where user_id = $this->user_id";
			$result = $this->db->query($sql);   	
			while ($row = $result->fetch_assoc()) {
				$this->projects[$row['id']] = new Project($row, $this->db);
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
