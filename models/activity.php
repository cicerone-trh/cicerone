<?php
	class Activity {

		private $id;
		private $project_id;
		private $owner_id;
		private $name;
		private $description;
		private $duration;
		private $dateCreated;
		private $url;
		private $db;

		private $typeString;			// temporary

		public $asArray;

		public function __construct($activityArray,$db) {

			// WELL SINCE WE DON'T HAVE OVERLOADING
			// if it is not array we're going to assume id was passed

			$this->db = $db;

			if (is_array($activityArray)){
				$this->buildFromArray($activityArray);
			} else {
				$this->id = $activityArray;
				$sql = "select * from cicerone_activities where id = $this->id";
				$result = $this->db->query($sql);
				$activityArray = $result->fetch_assoc();
				$this->buildFromArray($activityArray);
			}
		}

		private function buildFromArray($activityArray) {
			$this->asArray = $activityArray;

			$this->id = $activityArray['id'];
			$this->project_id = $activityArray['project_id'];
			$this->name = $activityArray['name'];
			$this->description = $activityArray['description'];
			$this->duration = $activityArray['duration'];
			$this->dateCreated = $activityArray['dateCreated'];
			$this->url = $activityArray['uriLink'];

			$this->typeString = $activityArray['types'];

			$this->determineOwner();
		}

		private function determineOwner() {
			$sql = "SELECT user_id FROM cicerone_projects WHERE id = " . $this->project_id;
			$result = $this->db->query($sql);
			$row = $result->fetch_assoc();
			$this->owner_id = $row['user_id'];
		}

		public function deleteActivity($user_id) {
			if ($user_id == $this->owner_id) {
				$sql = "DELETE FROM cicerone_activities WHERE id = " . $this->id;
				$this->db->query($sql);
				echo "deleted";
			} else {
				echo "access denied, not deleting";
			}
		}

		public function getDesc() {
			return $this->description;
		}

		public function getLink() {
			return $this->url;
		}

		public function getMDY() {
			$date = new DateTime($this->dateCreated);
			return $date->format('m-d-y');
		}

		public function getName() {
			return $this->name;
		}

		public function getId() {
			return $this->id;
		}

		public function getTime() {
			return $this->duration;
		}

		public function getTimeAsHours() {
			return number_format($this->duration/3600, 2);
		}

		public function getDateCreated() {
			return strtotime($this->dateCreated);
		}

		public function hasLink() {
			if ($this->url) {
				return true;
			} else {
				return false;
			}
		}

		public function saveToDB() {
			$sql = "UPDATE cicerone_activities" . 
				" SET name=\"" . $this->name . "\"" . 
				",duration=" . $this->duration .
				",description=\"" . $this->description . "\"" .
				",types=\"" . $this->typeString . "\"" .
				",project_id=" . $this->project_id .
				",uriLink=\"" . $this->url . "\"" .
				" WHERE id=". $this->id;
			
			$this->db->query($sql);
		}
	}	
?>	
