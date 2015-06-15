<?php
	class Activity {

		private $activity_id;
		private $name;
		private $description;
		private $duration;
		private $dateCreated;

		public function __construct($activityArray) {
			$this->activity_id = $activityArray['id'];
			$this->name = $activityArray['name'];
			$this->description = $activityArray['description'];
			$this->duration = $activityArray['duration'];
			$this->dateCreated = $activityArray['dateCreated'];
		}

		public function getDesc() {
			return $this->description;
		}

		public function getMDY() {
			$date = new DateTime($this->dateCreated);
			return $date->format('m-d-y');
		}

		public function getName() {
			return $this->name;
		}

		public function getId() {
			return $this->activity_id;
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
	}	
?>	
