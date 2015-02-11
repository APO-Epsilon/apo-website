<?php
require_once ('session.php');
require_once ('mysql_access.php');
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
		<div class="large-6 medium-6 small-12 columns">
			<h2>Register for the Conference</h2>
			<form action="register_process.php" method="POST">
				<label for="first_name">First Name</label>
				<input type="text" name="firstname"/>
			<br>
				<label for="last_name">Last Name</label>
				<input type="text" name="lastname" />
			<br>
				<label for="username">Email*</label>
				<input type="text" name="username" />
			<br>
				<label for="password">Password</label>
				<input type="password" name="password" />
			<br>
				<p align="center">
			 	<input type="hidden" name="stage" value="process" />
			 	<input type="submit" value="Register" />
			 	</p>
			</form>
		</div>
	</div>
	<br>

    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
