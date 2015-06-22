<?php

	require_once("activity.php");

	class Project {

		private $db;
		private $project_id;
		private $name;
		private $description;
		private $activities;

		public function __construct($projectArray, $db) {
		
			// if statement so can construct from id only

			if (is_array($projectArray)) {
				$this->db = $db;
				$this->project_id = $projectArray['id'];

				$this->name = $projectArray['name'];
				$this->description = $projectArray['description'];
			} else {
				$this->db = $db;
				$this->project_id = $projectArray;
			}

			$this->activities = array();
			$this->buildActivitiesList();
		}

		public function getActivities() {
			return $this->activities;
		}

		public function getDescription() {
			return $this->description;
		}

		public function getId() {
			return $this->project_id;
		}

		public function getName() {
			return $this->name;
		}

		public function getTime() {
			$totalSeconds = 0;
			foreach($this->activities as $activity){
				$totalSeconds += $activity->getTime();
			}
			return $totalSeconds;
		}

		public function getTimeByDates($dateStart, $dateEnd) {
			$totalTime = 0;
			foreach($this->activities as $activity) {
				if ($dateStart <= $activity->getDateCreated() && $dateEnd >= $activity->getDateCreated()){
					$totalTime += $activity->getTime();
				}
			}
			return $totalTime;
		}

		public function hasActivities() {
			if (count($this->activities) > 0) {
				return true;
			} else {
				return false;
			}
		}

		public function listActivities() {
			foreach ($this->activities as $activity) {
				$activity->displaySelf();
			}
		}

		private function buildActivitiesList() {
			$sql = "select * from cicerone_activities where project_id = $this->project_id";
			$result = $this->db->query($sql);
			while ($row = $result->fetch_assoc()){
				$this->activities[$row['id']] = new Activity($row,$this->db);
			}
		}
	}	
?>	
