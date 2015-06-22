<?php include("includes/header.php"); ?>

<!-- login form -->
<div class="content-header">
	<ul>
		<li><span data-order="1" id="about-link" class="js-link">About</span></li>
		<li><span data-order="2" id="view-link" class="js-link">View</span></li>
		<li><span data-order="3" id="donate-link" class="js-link">Donate</span></li>
		<li><span data-order="4" id="account-link" class="activeLink js-link">Login</span></li>
	</ul>
</div>
<div class="active-component" id="account-form">
	<div class="info" id="login-form">
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
	<div class="info hidden" id="create-form">
		<form id="createAccount" method="post" action="/includes/process.php">
			<label class="unit one-of-two">user name: </label>
			<label class="unit one-of-two">password: </label>
			<input class="unit one-of-two" name="new_username" type="text">
			<input class="unit one-of-two" name="new_password" type="password">

			<label class="unit one-of-two"></label>
			<label class="unit one-of-two">repeat password: </label>
			<span class="unit one-of-two"></span>
			<input class="unit one-of-two" name="confirm_password" type="password">



			<span style="margin-top:1em;" class="unit two-of-three">Say "please" (bots are rude):</span>
			<input style="margin-top:1em;" class="unit one-of-three" name="turing_test" type="text">
			<div style="margin-top: 1em;">
				<span class="unit one-of-two"></span>
				<span style="text-align: right" class="unit one-of-two"><input class="unit one-of-two" type="submit" name="create_account" value="Create Account"></span>
			</div>

		<span style="text-align:right" id="login-link" class="unit span-grid js-link">Back to Login</span>
		</form>	
		<div style="margin-left:3%">
		note: your password is encrypted and I refuse the liability of storing email addresses, 
		so if you forget your password there will be no way to access your account. However, because I'm sure I won't have too many users, if you forget, 
		you can shoot me an email that somehow proves you are you and I'll help you out.
		</div>
	</div>

</div>



<div class="info hidden" id="about-cic">
	<div id="about-1">
		<p>This is a web application I wrote for two reasons: to keep track of work on projects, and to display one's aptitude for doing a thing. </p>
		<p>First, the reason that I <span class=”emphasis”>actually</span> wrote it: I wanted to have a good way to monitor my progress on things, to keep me motivated and on task. Having a github is okay, but often it doesn't really capture what you learned and did. It is common when  writing a program to spend three hours on some aspect when the change in code is only a few lines. On github, this shows up as one commit with one minor change, but the actual process of arriving at that change is unrepresented; I feel my progress is lost.</p>
		<p>I prefer to think of activities and the time spent undertaking that activity, rather than an arbitrary “commit”.</p>
		<p>I like the idea that it takes 10,000 hours to master a skill. Thus, a big incentive for me is logging hours. So far, it has helped. As of this writing I have about 50 hours of activities logged and I am very eager to hit 100 and then 1,000. </p>
		<p>This helps me stay focused because the goal is hours, rather than solutions. I tend to procrastinate when I know there is a difficult problem that I don't presently know how to solve. I get caught up just trying to solve it in any way, as fast as possible, rather than spending time understanding the concepts and processes. I revel in spending time truly understanding something – this is, after all, the idea behind spending 10,000 hours mastering a skill.</p>
		<p>So, that's why I actually wrote it; it helps motivate me, and helps me to stay on track.</p>
		<span id="more-about" class="fr js-link">Next &gt;&gt;</span>
	</div>
	<div id="about-2" style="display:none">

		<p>But if that was the only idea behind it, it would be called “Archivist” and not “Cicerone”. A Cicerone was a person in the era of Grand Tours who specialized in the history of a locale; they knew what was important about an area and would act as a guide, teaching individuals about the relevance and history of the place. Thus, the “Cicerone” portion of the name comes from the “View” feature.</p>
		<p>The problem I originally wanted to solve was that of presenting knowledge of programming. This is a notoriously difficult ability to gauge, especially from the classical tool of a resume – as an example, one's education is often entirely moot.</p>
		<p>Cicerone then builds on the idea of constructivism by presenting projects and dissecting those projects into relevant activities, to give the evaluator a better idea of the individual's knowledge. Again, it may seem that a github account would do, but many things are not directly available in commits: often, for example, the changes to a database are omitted.</p>
		<p>And even if so, it takes a very keen eye to judge the mindset of the author. Are they aware they wrote something awful? At what point in time was this written, have they learned? What were they considering and why did they choose this particular method? Often the problem that was solved by a commit is clever but entirely overlooked. </p>
		<p>Ultimately, this is not yet implemented; I have only written was is currently important to me: recording my activities and the progress made on projects. </p>
		<span id="less-about" class="js-link">&lt;&lt; Back</span>
	</div>
</div>

<div class="info hidden" id="view-cic">
	<p>Eventually, you will be able browse and load the history of users that have made their histories public from here.</p>
	<p>For now, you can see a very shoddy example: <a href="/trh">trh's history</a></p>
</div>

<div class="info hidden" id="donate-cic">
	<p>In its current iteration, I have no plans for monetizing this app. In fact, I am working on a way of making this “web app” <a href="http://www.gnu.org/philosophy/free-sw.en.html" target="_blank">Free Software</a>.</p>
	<p>I have a list of features I intend on implementing, and after domain and hosting fees, all donations effectively go towards the implementation of these features.</p>
	<!-- paypal -->
	<form action="https://www.paypal.com/cgi-bin/webscr" target="_blank" method="post" target="_top">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
	">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
	<!-- end paypal -->
</div>

		<div id="processMessage">
		<?php 
			if (isset($_SESSION['processMessage'])) {
				echo $_SESSION['processMessage'];
				unset($_SESSION['processMessage']);
			}
		?>
		</div>

<?php include("includes/footer.php"); ?>
