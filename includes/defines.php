<?php
	// define filepaths -- index

	define('CIC_ROOT',			$_SERVER['DOCUMENT_ROOT']);
	define('CIC_HEADER', 		CIC_ROOT . "/includes/header.php");
	define('CIC_FOOTER', 		CIC_ROOT . "/includes/footer.php");

	// link within html that I will change in many places eventually
	define('CIC_INDEX_LINK',	'/new_index.php');

	function displayHours() {
		$sql = "SELECT duration, dateCreated FROM cicerone_activities";
		$result = $conn->query($sql);
		$totalSeconds = 0;
		$todaySeconds = 0;

		// for "past 24 hours" feature
		$dayAgo = strtotime("-24 hours");

		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$totalSeconds += $row['duration'];

				if (strtotime($row['dateCreated']) >= $dayAgo) {
					$todaySeconds += $row['duration'];
				}
			}
		}

		$totalHours = $totalSeconds / 60 / 60;
		$todayHours = $todaySeconds / 60 / 60;

		echo "<p>Total Hours Recorded: "; 
		echo number_format($totalHours, 2);
		echo "<br>Today: ";
		echo number_format($todayHours, 2);
		echo "</p>";
	}
?>
