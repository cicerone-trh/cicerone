<?php

	require_once('includes/defines.php');

	session_start();

	if (isset($_SESSION['user'])){			// if user is logged in
		include('views/home.php');
?>

<?php

	} else {								// if user is not logged in
		include('views/default.php');
	}

?>
