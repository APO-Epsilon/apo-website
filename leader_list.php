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

function delete_event_and_entries($eid)
{
  include ('mysql_access.php');
  $sql = "DELETE FROM `events_signup` WHERE `event_id` = '$eid'";
  $delete = $db->query($sql) or exit("There was an error, contact Webmaster");  
  $sql = "DELETE FROM `events_listing` WHERE `event_id` = '$eid' LIMIT 1";
  $delete = $db->query($sql) or exit("There was an error, contact Webmaster");
}

function close_event($eid)
{
   include ('mysql_access.php');
   $sql = "UPDATE events_listing SET closed=1 WHERE event_id=$eid LIMIT 1";
   $delete = $db->query($sql) or exit("There was an error, contact Webmaster");	
}

function open_event($eid)
{
   include ('mysql_access.php');
   $sql = "UPDATE events_listing SET closed=0 WHERE event_id=$eid LIMIT 1";
   $delete = $db->query($sql) or exit("There was an error, contact Webmaster");	
}

function delete_entry($entry) {
  include ('mysql_access.php');
  $sql = "DELETE FROM `events_signup` WHERE `entry_id` = '$entry' LIMIT 1";
  $delete = $db->query($sql) or exit("There was an error, contact Webmaster");
}

function cancel_event($entry) {
  include ('mysql_access.php');
  $sql = "UPDATE regular_service_details SET cancel=1 WHERE event_id=$entry LIMIT 1";
  $delete = $db->query($sql) or exit("There was an error, contact Webmaster");
}

function uncancel_event($entry) {
  include ('mysql_access.php');
  $sql = "UPDATE regular_service_details SET cancel=0 WHERE event_id=$entry LIMIT 1";
  $delete = $db->query($sql) or exit("There was an error, contact Webmaster");
}

function submit_event($entry) {
  include ('mysql_access.php');
  $user_id = $_SESSION['sessionID'];

		$wresponse=$db->query("SELECT week_cd FROM week LIMIT 1");
		$wres=mysqli_fetch_array($wresponse);
		$week_cd = $wres['week_cd'];

  $deets=$db->query("SELECT * FROM regular_service_details WHERE event_id = $entry");
  $dts=mysqli_fetch_array($deets);
  $svc_type = $dts['service_type'];
  $yth = $dts['youth'];

  $gen=$db->query("SELECT * FROM events_listing WHERE event_id = $entry");
  $gens=mysqli_fetch_array($gen);
  $desc = $gens['event_description'] . " Week #" . $week_cd;
  $event_name = $gens['event_name'];
  $hrs = $gens['S_val'];
  $cap = $gens['event_cap'];

  //for signed up at that week/day/event (and leader) submit hours
  $new = "INSERT INTO recorded_hours (user_id,month,day,year,date,semester,description,hours,servicetype,event,youth) VALUES ($user_id,1,1,2017,0,'Spring 2017','$desc',$hrs,'$svc_type','$event_name',$yth)";
  $subbed = $db->query($new) or die("Submit Failed");

  for ( $d=1; $d<=$cap; $d++)
  {
 	$sig=$db->query("SELECT * FROM events_signup WHERE event_id = $entry AND week=$week_cd AND Factor=$d");
  	$sg=mysqli_fetch_array($sig);	
	if (isset($sg['user_id'])) //if someone is signed up in this factor
	{
	$n_id = $sg['user_id'];
  	$new = "INSERT INTO recorded_hours (user_id,month,day,year,date,semester,description,hours,servicetype,event,youth) VALUES($n_id,1,1,2017,0,'Spring 2017','$desc',$hrs,'$svc_type','$event_name',$yth)";
  	$subbed = $db->query($new) or die("Submit  $d Failed");  
	}
  }


  $sql = "UPDATE regular_service_details SET closed=1 WHERE event_id=$entry LIMIT 1";
  $delete = $db->query($sql) or exit("There was an error, contact Webmaster");
}

function show_active() {
	echo "<h1>Events you are leading:</h1>";

	$user_id = $_SESSION['sessionID'];
   	include('mysql_access.php');

	if (isset($_GET['delete'])) {
		$entry = $_GET['delete'];
		delete_entry($entry);
	}
	else if (isset($_GET['cancel'])) {
		$entry = $_GET['cancel'];
		cancel_event($entry);
	}
	else if (isset($_GET['uncancel'])) {
		$entry = $_GET['uncancel'];
		uncancel_event($entry);
	}
	else if (isset($_GET['submit'])) {
		$entry = $_GET['submit'];
		submit_event($entry);
	}
	else if (isset($_GET['delete_event'])) {
		$eid = $_GET['delete_event'];
		delete_event_and_entries($eid);
	}
	else if (isset($_GET['open'])) {
		$eid = $_GET['open'];
		open_event($eid);
	}
	else if (isset($_GET['end'])) {
		$eid = $_GET['end'];
		close_event($eid);
	}

	//if rec sec, display all chapter events first
		$vesponse=$db->query("SELECT position FROM contact_information WHERE id=$user_id LIMIT 1");
		$vesult=mysqli_fetch_array($vesponse);
	if($vesult['position'] == 'Recording Secretary')
	{
		$response=$db->query("SELECT * FROM events_listing WHERE event_leader_id = $user_id OR event_type = 'Chapter'");		
	}
	else
	{
		$response=$db->query("SELECT * FROM events_listing WHERE event_leader_id = $user_id");		
	}
	while($result=mysqli_fetch_array($response))
	{
		$wresponse=$db->query("SELECT week_cd FROM week LIMIT 1");
		$wres=mysqli_fetch_array($wresponse);
		$week_cd = $wres['week_cd'];

		$eid = $result['event_id'];

		$dsearch=$db->query("SELECT * FROM regular_service_details WHERE event_id=$eid");
		$daily=mysqli_fetch_array($dsearch);

		//set cancel or uncancel
		if($result['event_type'] == 'Regular Service')
		{
		if ($daily['cancel'] == 0)
		{
			$cancel = "<sup><a href='leader_list.php?cancel=$eid'>Cancel?</a></sup>";
		}
		else
		{		
			$cancel = "<sup><a href='leader_list.php?uncancel=$eid'>Uncancel?</a></sup>";
		}
		//set submit or null
		if ($daily['closed'] == 0)
		{
			$submit = "<sup><a href='leader_list.php?submit=$eid'>Submit?</a></sup>";
		}
		else
		{		
			$submit = "submitted";
		}
		}
		else
		{
			$cancel = "<sup><a href='leader_list.php?delete_event=$eid'>Delete Event?</a></sup>";
			if ($result['closed'] == 1)
			{
				$submit = "<sup><a href='leader_list.php?open=$eid'>Open?</a></sup>";
			}
			else
			{
				$submit = "<sup><a href='leader_list.php?end=$eid'>Close?</a></sup>";
			}
		}
		?>
		<table>
		<tr><td colspan="2"><?= $result['event_name'] ?></td><td>Type: <?= $result['event_type'] ?> </td>
		<td><?= $submit ?></td><td><?= $cancel ?></td></tr>
		<tr><td colspan="5"><?= $result['event_description'] ?></td></tr>
		<tr><th>#</th><th>Name</th><th>Email</th><th>Note</th><th>Delete?</th></tr>
		<?php
		//loop for each participant. Display name, factor, and email!
		$count = 0;
		global $current_semester;
		//$aresponse=$db->query("SELECT user_id,factor,entry_id FROM events_signup WHERE event_id = $eid AND week = $week_cd");
		$aresponse=$db->query("SELECT user_id,factor,entry_id FROM events_signup WHERE event_id = $eid AND semester='$current_semester'");

		while($aresult=mysqli_fetch_array($aresponse))
		{
			$count++;
			$entry = $aresult['entry_id'];
			$uid = $aresult['user_id'];
			$uresponse=$db->query("SELECT firstname,lastname,email FROM contact_information WHERE id = $uid");
			$uresult=mysqli_fetch_array($uresponse);
			echo "<tr><td>" . $count . "</td><td>" . $uresult['firstname'] . " " . $uresult['lastname'] . "</td><td>" . $uresult['email'] . "<td></td><td><sup><a href='leader_list.php?delete=$entry'>Delete?</a></sup></td>";
			echo "</tr>";
		}
		?>
		</table>
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
