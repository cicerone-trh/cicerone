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
	<form id="loginForm" method="post" action="/includes/login.php">
		<div>
			<label>user name: </label><input name="username" type="text">
		</div>
		<div class="clear">
			<label>password: </label><input name="password" type="password">
		</div>
		<div class="clear">
			<input type="submit"> 
		</div>
	</form>
</div>

<div id="create-form">
	<h2>Create Account</h2>
	<form id="createAccount" method="post" action="/includes/process.php">
		<input name="new_username">
		<input name="new_password" type="password">
		<input name="create-account" type="submit">
	</form>	
</div>


<?php include(CIC_FOOTER); ?>
