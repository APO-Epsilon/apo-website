<?php
require_once ('session.php');
require_once ('../mysql_access.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body class="slide" data-type="background" data-speed="5">
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->

	<div class="row">

<?php
if (!isset($_SESSION['sessionConfID'])) {
?>
		<div class="small-12 columns">
			<h2>Register for the Conference</h2>
		</div>
	</div>
	<form action="register_process.php" method="POST">
		<div class="row">
			<div class="medium-8 small-12 small-centered columns">
				<div class="row">
					<fieldset>
						<legend>Personal Information</legend>	
						<div class="medium-6 small-12 columns">
							<label for="first_name">First Name</label>
							<input type="text" name="firstname"/>
						</div>
						<div class="medium-6 small-12 columns">
							<label for="last_name">Last Name</label>
							<input type="text" name="lastname" />
						</div>
						<div class="medium-6 small-12 columns">
							<label for="email">Email</label>
							<input type="text" name="email" />
						</div>
						<div class="medium-6 small-12 columns">
							<label for="password">Password</label>
							<input type="password" name="password" />
						</div>
					</fieldset>
					<fieldset>
						<legend>APO Information</legend>
						<div class="medium-6 small-12 columns">
							<label for="chapter">Chapter
							<select name="chapter">
								<option value=""></option>
								<option value="Epsilon">Epsilon</option>
								<option value="Alpha Phi">Alpha Phi</option>
								<option value="Alpha Omega">Alpha Omega</option>
								<option value="Beta Psi">Beta Psi</option>
								<option value="Delta Delta">Delta Delta</option>
								<option value="Epsilon Pi">Epsilon Pi</option>
								<option value="Sigma Alpha">Sigma Alpha</option>
								<option value="Chi Omega">Chi Omega</option>
								<option value="Alpha Delta Sigma">Alpha Delta Sigma</option>
							</select>
							</label>
						</div>
						<div class="medium-6 small-12 columns">
							<label for="status">Status</label>
							<select name="status">
								<option value=""></option>
								<option value="Active">Active</option>
								<option value="Pledge">Pledge</option>
								<option value="Alumni">Alumni</option>
							</select>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="large-6 medium-6 small-12 large-offset-3 medium-offset-3 columns">
			 	<input type="hidden" name="stage" value="process" />
			 	<input type="submit" class="button expand" value="Register" />
	 		</div>
	 	</div>
	</form>
<?php
} else {
?>
		<div class="small-12 columns">
			<p>It appears that you're already registered for the conference. If you'd like to register another attendee, please click the "Logout" button below and then return to this page.</p>
		</div>
		<div class="small-12 columns">
			<a href="login.php" class="button expand">Logout</a>
		</div>
<?php
}
?>
	</div>
	<br>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
