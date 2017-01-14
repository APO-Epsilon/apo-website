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

<?php
$exec_page = False;
$active_page = True;
$public_page = False;
require_once('permissions.php');

function show_active() {
	//check for proper parameters
	if(isset($_POST['submit']))
	{
		include('mysql_access.php');
		//add their signup to the database
		$SQL = "INSERT INTO events_signup (event_id,user_id, semester) VALUES (" . $_POST['event_id'] . "," . $_POST['user'] . ",'Spring 2017')";
		$result = $db->query($SQL) or die("Signup Failed");
	}
	echo '<h1> You are Signed Up for ' .  $_POST['event_name'] . '! </h1>';
	//change this link from test site to real site before uploading
	echo "<a href='event_signup.php'>SIGN UP FOR ANOTHER EVENT</a>";
	echo "<br><br><a href='check_requirements.php'>CHECK REQUIREMENTS HERE</a>";
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
