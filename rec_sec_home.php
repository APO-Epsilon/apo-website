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
	
	include('mysql_access.php');
	include('retrieve_user.php');
	$user_id = $_SESSION['sessionID'];	

	$position = id_to_position($user_id);
	if ($position == "Webmaster" || $position == "Recording Secretary") {
	?>
	<p><a href="missed_meeting.php">Meeting Absence</a></p>
	<p><a href="enter_excuse.php">Excused Absence</a></p>
	<p><a href="rec_sec_attendance_tool.php">Attendance Tool</a></p>
	<p><a href="req_view.php">See All Requirements Status</a></p>
	<?php
	}
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
