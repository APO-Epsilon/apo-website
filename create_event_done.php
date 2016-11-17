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
	$user_id = $_SESSION['sessionID'];	
	$aresponse=$db->query("SELECT status FROM contact_information WHERE id=$user_id");
	$aresult=mysqli_fetch_array($aresponse);
	$status = $aresult['status'];
if ($status == 'Appointed' || $status == 'Elected') {
	if (isset($_POST['submit']) && isset($_POST['event_name'])) 
	{
		$event_type = htmlspecialchars($_POST['event_type']);
		$event_id = htmlspecialchars($_POST['event_id']);
		$event_name = htmlspecialchars($_POST['event_name']);
		$L_val = htmlspecialchars($_POST['L_val']);
		$F_val = htmlspecialchars($_POST['F_val']);
		$event_time = htmlspecialchars($_POST['event_time']);
		$event_place = htmlspecialchars($_POST['event_place']);
		$event_description = htmlspecialchars($_POST['event_description']);
		$event_cap = htmlspecialchars($_POST['event_cap']);
		$event_leader_id = htmlspecialchars($_POST['event_leader_id']);
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
		
		//add their signup to the database
		$SQL = "INSERT INTO events_listing ";
		$SQL = $SQL . "(event_type,event_id,event_name,L_val,F_val,event_time,event_place,event_description,event_cap,event_leader_id,repeatable,required)";
		$SQL = $SQL . " VALUES ('";
		$SQL = $SQL . $event_type . "'," . $event_id . ",'" . $event_name . "'," . $L_val . "," . $F_val . ",'" . $event_time . "','";
		$SQL = $SQL . $event_place . "','" . $event_description . "'," . $event_cap . "," . $event_leader_id . ",";
		$SQL = $SQL . $repeatable . "," . $required . ")";
		$result = $db->query($SQL) or die("<a href='create_point_event.php'>Create an Event</a>");
		echo "<h1>Event " . $event_name . " successfully created!</h1>";
				
		//check input
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
else{
	echo "Only exec can create events.";
}
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
