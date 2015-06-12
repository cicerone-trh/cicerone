	<footer>
<?php 
	if (isset($_SESSION['processMessage'])) {
		echo $_SESSION['processMessage'];
		unset($_SESSION['processMessage']);
	}
?>
	</footer>
</div><!-- end container -->
</body>
</html>

