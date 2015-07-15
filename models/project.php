<?php

	require_once("activity.php");

	class Project {

		private $db;
		private $owner_id;
		private $project_id;
		private $name;
		private $description;
		private $url;
		private $currentlyActive;
		private $activities;

		public $asArray;

		public function __construct($projectArray, $db) {
			$this->db = $db;

			// if statement so can construct from id only
			
			if (is_array($projectArray)) {
				$this->project_id = $projectArray['id'];
				$this->buildFromArray($projectArray);

			// only given id
			} else {
				$this->project_id = $projectArray;
				$sql = "select * from cicerone_projects where id = $this->project_id";
				$result = $this->db->query($sql);
				$projectArray = $result->fetch_assoc();
				$this->buildFromArray($projectArray);
			}

			$this->activities = array();
			$this->buildActivitiesList();
		}

		private function buildFromArray($projectArray) {
			$this->asArray = $projectArray;

			$this->owner_id = $projectArray['user_id'];
			$this->currentlyActive = $projectArray['isActive'];
			$this->name = $projectArray['name'];
			$this->description = $projectArray['description'];
			$this->url = $projectArray['uriLink'];
		}

		public function deleteProject() {
			if ($_SESSION['user_id'] == $this->owner_id) {
				$sql = "DELETE FROM cicerone_projects WHERE id= " . $this->project_id;
				if($this->db->query($sql)){
					$_SESSION['processMessage'] = "Project deleted.";
				} else {
					$_SESSION['processMessage'] = "DB Error.";
				}
			} else {
				$_SESSION['processMessage'] = "You do not have permission to delete this.";
			}
		}

		public function getActivities() {
			krsort($this->activities);
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

		public function isActive() {
			return $this->currentlyActive;
		}

		public function saveToDB() {
			$success = true;
			if ($stmt = $this->db->prepare(
				"UPDATE cicerone_projects " .
				"SET name=?,description=?,isActive=?,uriLink=? " .
				"WHERE id=". $this->project_id	
			)) {	
				$stmt->bind_param(ssis, $this->name, $this->description, $this->currentlyActive, $this->url);
				if (!$stmt->execute()){
					$success = false;
				}
			} else {
				$success = false;
			}

			return $success;
		}

		public function toggleActive() {
			// verify user is owner:
			if ($_SESSION['user_id'] == $this->owner_id) {
				$newState = ($this->currentlyActive ? 0 : 1);
				$sql = "UPDATE cicerone_projects SET isActive=$newState WHERE id=$this->project_id"; 
				$this->db->query($sql);
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
