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
	if (isset($_POST['submit']) && isset($_POST['event_title'])) 
	{
		$event_id = $_POST['event_id'];
		$event_type = $_POST['event_type'];
		$cap = $_POST['cap'];
		$event_description = $_POST['event_description'];
		$repeatable = 0;
		if (isset($_POST['repeatable']))
		{
			$repeatable = 1;
		}
		$F_val = $_POST['F_val'];
		$L_val = $_POST['L_val'];
		$event_title = $_POST['event_title'];
		//add their signup to the database
		$SQL = "INSERT INTO events_listing (event_id,event_name,event_description,F_val,L_val,event_cap,event_type,repeatable) VALUES (" . $event_id . ",'". $event_title . "','". $event_description ."',". $F_val . ",". $L_val . "," . $cap . ",'" . $event_type . "'," . $repeatable . ")";
		$result = $db->query($SQL) or die("<a href='create_point_event.php'>Create an Event</a>");
		echo "<h1>Event " . $event_title . " successfully created!</h1>";
	}
	echo "<a href='create_point_event.php'>Create a Point Event</a><br>";
	//display all events in a table
	$response=$db->query("SELECT event_name,L_val,F_val,repeatable FROM events_listing WHERE event_type='Point'");
	$count = 0;
	echo "<table>";
	echo "<tr><td>#</td><td>Name</td><td>Leadership</td><td>Friendship Points</td><td>Repeatable</td></tr>";
	while($result=mysqli_fetch_array($response)){ 
		$count++;
		echo "<tr><td>".$count . "</td>";
		echo "<td>" . $result['event_name'] . "</td>";
		echo "<td>" . $result['L_val'] . "</td>";
		echo "<td>" . $result['F_val'] . "</td>";
		echo "<td>" . $result['repeatable'] . "</td></tr>";
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
