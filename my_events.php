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

function delete_event($entry) {
  include ('mysql_access.php');
  $sql = "DELETE FROM `events_signup` WHERE `entry_id` = '$entry' LIMIT 1";
  $delete = $db->query($sql) or exit("There was an error, contact Webmaster");
}

function show_active() {
	
	if (isset($_GET['delete'])) {
		$entry = $_GET['delete'];
		delete_event($entry);
	}	
	
	echo "<h1>My Events</h1>";

	$user_id = $_SESSION['sessionID'];
   	include('mysql_access.php');

	$response=$db->query("SELECT * FROM events_signup WHERE user_id = $user_id");
	echo "<table>";
	echo "<tr><th>#</th><th>Name</th><th>Type</th><th>Delete?</th></tr>";
	$i = 0;
	while($result=mysqli_fetch_array($response))
	{
		$eid = $result['event_id'];
		$entry = $result['entry_id'];
		$check=$db->query("SELECT * FROM events_listing WHERE event_id=$eid");
		while($done=mysqli_fetch_array($check))
		{
			$i++;
			$event = $done['event_name'];
			$type = $done['event_type'];
			echo "<tr><td>$i</td><td>$event</td><td>$type</td><td><sup><a href='my_events.php?delete=$entry'>Delete?</a></sup></td></tr>";
		}
		
		
	}
	echo "</table>";
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
