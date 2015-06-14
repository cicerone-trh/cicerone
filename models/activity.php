<?php
	class Activity {

		private $name;
		private $description;
		private $duration;
		private $dateCreated;

		public function __construct($activityArray) {
			$this->name = $activityArray['name'];
			$this->duration = $activityArray['duration'];
			$this->dateCreated = $activityArray['dateCreated'];
		}

		public function getName() {
			return $this->name;
		}

		public function getDesc() {
			return $this->description;
		}

		public function getTime() {
			return $this->duration;
		}

		public function getDateCreated() {
			return strtotime($this->dateCreated);
		}
	}	
?>	
