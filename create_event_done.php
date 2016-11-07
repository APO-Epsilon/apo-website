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
	if (isset($_POST['submit']) && isset($_POST['event_name'])) 
	{
		$event_type = $_POST['event_type'];
		$event_id = $_POST['event_id'];
		$event_name = $_POST['event_name'];
		$F_val = $_POST['L_val'];
		$L_val = $_POST['F_val'];
		$event_time = $_POST['event_time'];
		$event_place = $_POST['event_place'];
		$event_description = $_POST['event_description'];
		$event_cap = $_POST['event_cap'];
		$event_leader_id = $_POST['event_leader_id'];
		$repeatable = 0;
		if (isset($_POST['repeatable']))
		{
			$repeatable = 1;
		}
		$required = 0;
		if (isset($_POST['required']))
		{
			$required = 1;
		}
		
		//check input for now
		echo "Event Type: " . $event_type . '<br>';
		echo "Event ID: " . $event_id . '<br>';
		echo "Event Name: " . $event_name . '<br>';
		echo "Leadership: " . $L_val . '<br>';
		echo "Friendship: " . $F_val . '<br>';
		echo "Time: " . $event_time . '<br>';
		echo "Place: " . $event_place . '<br>';
		echo "Description: " . $event_description . '<br>';
		echo "Capacity: " . $event_cap . '<br>';
		echo "Leader ID: " . $event_leader_id . '<br>';
		echo "Repeatable: " . $repeatable . '<br>';
		echo "Required: " . $required . '<br>';
		
		//Chapter event leader is the rec sec (so use this for chp events)
			//$rresponse=$db->query("SELECT id FROM contact_information WHERE position='Recording Secretary'");
			//$rresult=mysqli_fetch_array($rresponse);
			//$rec_id = $rresult['id'];
		
		//add their signup to the database
			//$SQL = "INSERT INTO events_listing (event_id,event_name,event_description,F_val,L_val,event_cap,event_type,repeatable,required,event_leader_id) VALUES (" . $event_id . ",'". $event_name . "','". $event_description ."',". $F_val . ",". $L_val . "," . $event_cap . ",'" . $event_type . "'," . $repeatable . "," . $required . "," . $leader_id . ")";
			//$result = $db->query($SQL) or die("<a href='create_point_event.php'>Create an Event</a>");
			//echo "<h1>Event " . $event_name . " successfully created!</h1>";
	}
	echo "<a href='create_event.php'>Create an Event</a><br>";
	//display all events in a table
	$response=$db->query("SELECT event_name,event_type FROM events_listing");
	$count = 0;
	echo "<table>";
	echo "<tr><td>#</td><td>Name</td><td>Type</td></tr>";
	while($result=mysqli_fetch_array($response))
	{ 
		$count++;
		echo "<tr><td>".$count . "</td>";
		echo "<td>" . $result['event_name'] . "</td>";
		echo "<td>" . $result['event_type'] . "</td></tr>";
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
