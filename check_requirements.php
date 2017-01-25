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

function list_stats($hours_id, $semester) {
  include ('mysql_access.php');
  // Total Hours
  $sql = "SELECT SUM(hours) AS `sum_hours` FROM `recorded_hours` WHERE `user_id` = '$hours_id' AND `semester` = '$semester' LIMIT 1";
  $results = $db->query($sql) or die("Error Calculating Hours. $db->error");
  while($i = mysqli_fetch_array($results)) {
	$hrs = 0;
	if ($i['sum_hours'] > 0) 
	{
		$hrs = round($i['sum_hours'], 2);
	}
    echo "<span>Total Hours:</span> $hrs of 25<br/>";
  }
  $results->free();
  // APO Hours
  $sql = "SELECT SUM(hours) AS `sum_hours` FROM `recorded_hours` WHERE `user_id` = '$hours_id' AND `event` != 'Non-APO Hours'  AND `semester` = '$semester' LIMIT 1";
  $results = $db->query($sql) or die("Error Calculating Hours");
  while($i = mysqli_fetch_array($results)) {
	$hrs = 0;
	if ($i['sum_hours'] > 0) 
	{
		$hrs = round($i['sum_hours'], 2);
	}
    echo "<span>APO Hours:</span> $hrs of 10<br/>";
  }
  $results->free();
  // Fundraising Hours
  $sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = '$hours_id' AND `fundraising` = '1'  AND `semester` = '$semester' LIMIT 1";
  $results = $db->query($sql) or die("Error Calculating Hours");
  while($i = mysqli_fetch_array($results)) {
	$hrs = 0;
	if ($i['sum_hours'] > 0) 
	{
		$hrs = $i['sum_hours'];
	}
    echo "<span>Fundraising Hours:</span> $hrs of 3<br/>";
  }
  $results->free();
  // Bought Hours
  $sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = '$hours_id' AND `event` = 'Bought Hours'  AND `semester` = '$semester' LIMIT 1";
  $results = $db->query($sql) or die("Error Calculating Hours");
  while($i = mysqli_fetch_array($results)) {
	$hrs = 0;
	if ($i['sum_hours'] > 0) 
	{
		$hrs = $i['sum_hours'];
	}
    echo "<span>Bought Hours:</span> $hrs of maximum 5<br/>";
  }
  $results->free();
  echo "<br><p>You need 3 of the four C categories :</p>";
  $c_count = 0;
  // Chapter Hours
  $sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = '$hours_id' AND `servicetype` = 'Chapter'  AND `semester` = '$semester' LIMIT 1";
  $results = $db->query($sql) or die("Error Calculating Hours");
  while($i = mysqli_fetch_array($results)) {
	$hrs = 0;
	if ($i['sum_hours'] > 0) 
	{
		$hrs = round($i['sum_hours'], 2);
		$c_count++;
	}
    echo "<span>Chapter Hours:</span> $hrs<br/>";
  }
  $results->free();
  // Campus Hours
  $sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = '$hours_id' AND `servicetype` = 'Campus'  AND `semester` = '$semester' LIMIT 1";
  $results = $db->query($sql) or die("Error Calculating Hours");
  while($i = mysqli_fetch_array($results)) {
	$hrs = 0;
	if ($i['sum_hours'] > 0) 
	{
		$hrs = round($i['sum_hours'], 2);
		$c_count++;
	}
    echo "<span>Campus Hours:</span> $hrs<br/>";
  }
  $results->free();
  // Community Hours
  $sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = '$hours_id' AND `servicetype` = 'Community'  AND `semester` = '$semester' LIMIT 1";
  $results = $db->query($sql) or die("Error Calculating Hours");
  while($i = mysqli_fetch_array($results)) {
	$hrs = 0;
	if ($i['sum_hours'] > 0) 
	{
		$hrs = round($i['sum_hours'], 2);
		$c_count++;
	}
    echo "<span>Community Hours:</span> $hrs<br/>";
  }
  $results->free();
  // Country Hours
  $sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = '$hours_id' AND `servicetype` = 'Country'  AND `semester` = '$semester' LIMIT 1";
  $results = $db->query($sql) or die("Error Calculating Hours");
  while($i = mysqli_fetch_array($results)) {
	$hrs = 0;
	if ($i['sum_hours'] > 0) 
	{
		$hrs = $i['sum_hours'];
		$c_count++;
	}
    echo "<span>Country Hours:</span> $hrs<br/>";
  }
  echo "<p>You have " . $c_count . " of the 3 C's.</p>";
  $results->free();
}

function delete_event($eid, $user_id) {
  include ('mysql_access.php');
  $sql = "DELETE FROM `events_signup` WHERE `event_id` = '$eid' AND `user_id` = '$user_id' LIMIT 1";
  $delete = $db->query($sql) or exit("There was an error, contact Webmaster");
}

function display_event_table($rtype)
{
	include('mysql_access.php');
	$user_id = $_SESSION['sessionID'];
	//get events for the user
	$response=$db->query("SELECT event_id FROM events_signup WHERE user_id='" . $user_id . "'");
	
	if ($rtype == "Leadership" || $rtype == "Friendship")
	{
	if ($rtype == "Leadership")
	{
		$val = "L_val";
		$points_needed = 4;
	}
	else if ($rtype == "Friendship")
	{
		$val = "F_val";
		$points_needed = 4;
	}
		echo "<h3>" . $rtype . " - " . $points_needed . " Points</h3>";
		echo "<a href='event_signup.php'>Add events here.</a><br>";
		$count = 0;
		$points = 0;
		echo "<table>";
		echo "<tr><td>#</td><td>Event Name</td><td>" . $rtype . " Points</td><td>Event Leader</td><td>Leader Email</td><td>Event Type</td><td>Delete</td></tr>";
		while($result=mysqli_fetch_array($response))
		{ 
		//pull info for that event_id
			$eid = $result['event_id'];
			$eresponse=$db->query("SELECT event_name, " . $val . ",event_leader_id,event_type FROM events_listing WHERE event_id='" . $eid . "'");
			$eresult=mysqli_fetch_array($eresponse);
			if ($eresult[$val] > 0)
			{
				$count++;
				echo "<tr><td>".$count . "</td>";
				echo "<td>" . $eresult['event_name'] . "</td>";
				echo "<td>" . $eresult[$val] . "</td>";
				//get leader name & email
				$lresponse=$db->query("SELECT firstname,lastname,email FROM contact_information WHERE id='" . $eresult['event_leader_id'] . "'");
				$lresult=mysqli_fetch_array($lresponse);
				echo "<td>" . $lresult['firstname'] . " " . $lresult['lastname'] . "</td>";
				echo "<td>" . $lresult['email'] . "</td>";		
				echo "<td>" . $eresult['event_type'] . "</td>";
				echo "<td><sup><a href='check_requirements.php?delete=$eid'>Delete?</a></sup></td></tr>";
				$points = $points + $eresult[$val];
			}
		}
		echo "<tr><td></td><td>Total</td><td>" . $points . "</td></tr>";
		echo "</table>";
		echo "<p>You have " . $points . " of 4 points.</p>";
	}
	else if ($rtype == "Service")
	{
			
		echo "<h3>Service - 25 Hours</h3>";
		echo "More Service information and add hours <a href='service_hours.php'>HERE!</a><br><br>";
		list_stats($user_id,"Fall 2016");
	}
	else if ($rtype == "Required")
	{
		echo "<h3>Required Events</h3>";
		$theresponse=$db->query("SELECT event_name FROM events_listing WHERE required=1");
		while($reqevent=mysqli_fetch_array($theresponse))
		{
			echo $reqevent['event_name'] . '<br>';
		}
		echo "Meetings (5 excused and 3 unexcused absences)<br>";

	}
	else
	{
		echo "Error : Incorrect Display Type";
	}
}

function show_active() {
	include('mysql_access.php');
	
	//$response=$db->query("SELECT event_name,L_val,F_val,repeatable FROM events_listing WHERE event_type='Point'");
	//$count = 0;
	$user_id = $_SESSION['sessionID'];
	$SQL = "SELECT lastname,firstname,status FROM contact_information WHERE id=" . $user_id;
	$response=$db->query($SQL);
	$result=mysqli_fetch_array($response);
	echo "<h1>Requirements for " . $result['firstname'] . " " . $result['lastname'] . "</h1>";
	echo "<h2>ID# " . $user_id . " Status: " . $result['status'] . "</h2>";

	echo "This is a brand new page. If you have any issues or thoughts, please contact Adam Callanan at apo.epsilon.webmaster@gmail.com";
	
	if ($result['status']=='Active' ||$result['status']=='Appointed' ||$result['status']=='Elected') {
		
	//keep track of progress?
	//echo "you have not met all the requirements :(<br>";
	//echo "you have x excused absences left of y<br>";
	//echo "you have x unexcused absences left of y<br>";

	if (isset($_GET['delete'])) {
		$user_id = $_SESSION['sessionID'];
		$eid = $_GET['delete'];
		delete_event($eid, $user_id);
	}
	
	echo "<h3>Committee - 3 taskforce events</h3>";
	$c_events = 0;
	echo "<table><tr><th>#</th><th>Event Name</th><th>Event Leader</th></tr>";
	$zresponse=$db->query("SELECT event_id FROM events_signup WHERE user_id='" . $user_id . "'");
	while($zresult=mysqli_fetch_array($zresponse))
	{
		$taskq=$db->query("SELECT * FROM events_listing WHERE event_id='" . $zresult["event_id"] . "'");
		$taskr=mysqli_fetch_array($taskq);
		if($taskr['event_type'] == 'Taskforce')
		{
			$ename = $taskr['event_name'];
			$elid = $taskr['event_leader_id'];
			$eq=$db->query("SELECT email FROM contact_information WHERE id=$elid");
			$er=mysqli_fetch_array($eq);
			$leader_email = $er['email'];
			
			$c_events++;
			echo "<tr><td>$c_events</td><td>$ename</td><td>$leader_email</td></tr>";
		}
	}
	
	echo "<tr><td></td><td>Total</td><td>$c_events</td></tr></table>";
	echo "<p>You have $c_events of 3 events.</p>";
	
	display_event_table("Leadership");
	display_event_table("Friendship");
	display_event_table("Service");
	display_event_table("Required");

	//add submit button and send to recsec ?
	//echo "<br><br><input type=submit value='submit'>";
	}
	else
	{
		echo "Sorry, this page only handles Active requirements at the moment.";
	}
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
