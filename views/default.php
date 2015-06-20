<?php include(CIC_HEADER); ?>

<!-- login form -->
<div class="content-header">
	<ul>
		<li><span data-order="1" id="about-link" class="js-link">About</span></li>
		<li><span data-order="2" id="view-link" class="js-link">View</span></li>
		<li><span data-order="3" id="donate-link" class="js-link">Donate</span></li>
		<li><span data-order="4" id="account-link" class="activeLink js-link">Login</span></li>
	</ul>
</div>
<div class="grid active-component" id="account-form">
	<div class="unit one-of-five"></div>
	<div class="unit three-of-five" id="login-form">
		<form id="loginForm" method="post" action="/includes/login.php">
			<label class="unit one-of-two">user name: </label>
			<label class="unit one-of-two">password: </label>
			<input class="unit one-of-two" name="username" type="text">
			<input class="unit one-of-two" name="password" type="password">
			<div style="margin-top: 1em;">
				<span class="unit one-of-two"></span>
				<span style="text-align: right" class="unit one-of-two"><input class="unit one-of-two" type="submit" value="Login"></span>
			</div>
			<span style="text-align:right" id="create-link" class="unit span-grid js-link">Need Account?</span>

		</form>
	</div>
	<div class="hidden" id="create-form">
		<form id="createAccount" method="post" action="/includes/process.php">
			<label class="unit one-of-two">user name: </label>
			<label class="unit one-of-two">password: </label>
			<input class="unit one-of-two" name="new_username" type="text">
			<input class="unit one-of-two" name="new_password" type="password">
			<div style="margin-top: 1em;">
				<span class="unit one-of-two"></span>
				<span style="text-align: right" class="unit one-of-two"><input class="unit one-of-two" type="submit" name="create_account" value="Create Account"></span>
			</div>

		<span style="text-align:right" id="login-link" class="unit span-grid js-link">Back to Login</span>
		</form>	
	</div>
	<div class="unit one-of-five"></div>

</div>



<div class="info hidden" id="about-cic">
	<h2>About</h2>
	<p>This is a web application I wrote to keep track of your work on projects. More information about why this is valuable vs say github or time tracker software at my blog</p>
</div>

<div class="info hidden" id="view-cic">
	<h2>View a History</h2>
	<p>You can search for histories here, or you can see an example: <a>trh</a></p>
</div>

<div class="info hidden" id="donate-cic">
	<h2>Donate</h2>
	<p>I'm poor, please donate so I don't die.</p>
</div>


<?php include(CIC_FOOTER); ?>
