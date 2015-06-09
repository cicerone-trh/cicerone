<?php include(CIC_HEADER); ?>

<!-- login form -->
<div class="content-header">
	<ul>
		<li><a href="">About</a></li>
		<li><a href="">View</a></li>
		<li><a href="">Donate</a></li>
		<li><a href="">Create Account</a></li>
	</ul>
</div>
<div class="form-div" id="login-form">
	<form action="/includes/login.php">
		<div>
			<label>user name: </label><input type="text">
		</div>
		<div class="clear">
			<label>password: </label><input type="password">
		</div>
		<div class="clear">
			<input type="submit"> 
		</div>
	</form>
</div>


<?php include(CIC_FOOTER); ?>
