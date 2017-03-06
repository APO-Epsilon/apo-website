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
	global $current_semester;
	$user_id = $_SESSION['sessionID'];	

	function select($operand, $condition, $value)
	{
		include('mysql_access.php');
		$query = "SELECT $operand FROM contact_information WHERE $condition = '$value'";
		$results=$db->query($query);
		$final=mysqli_fetch_array($results);
	
		$results->free();
	
		return $final[$operand];
	}
	
	function id_to_position ($id)
	{
		$operand = 'position';
		$condition = 'id';
	
		$position = select($operand, $condition, $id);
	
		return $position;
	}
	
	$position = id_to_position($user_id);
	if ($position == "Webmaster" || $position == "Recording Secretary") {
		
		//give a table of all normal members
		//first: status active/elected/appointed
		?>
		<h1>Active Brothers</h1>
		<table>
		<tr><th>ID</th><th>Name</th><th>Email</th><th>Leadership</th><th>Friendship</th><th>Service</th><th>Committee</th><th>Excused</th><th>Unexcused</th></tr>
		
		<?php
		
		//get a list of all active brother
		$response=$db->query("SELECT id,firstname,lastname,email FROM contact_information WHERE status = 'Active' OR status = 'Elected' OR status = 'Appointed'");		
				include('retrieve_event.php');
		while($result=mysqli_fetch_array($response))
		{
			//general info
			$id = $result['id'];
			$name = $result['firstname'] . " " . $result['lastname'];
			$email = $result['email'];
			echo "<tr><td>$id</td><td>$name</td><td>$email</td>";
			
			//hours and points
			//how many l in current semester?
			$wresponse=$db->query("	SELECT sum(l_val)
									FROM events_signup 
									LEFT JOIN events_listing
									ON events_signup.event_id = events_listing.event_id
									WHERE events_signup.user_id = $id AND events_signup.semester = '$current_semester'");
			$wres=mysqli_fetch_array($wresponse);
			$l = $wres['sum(l_val)'];
			if ($l == null)
			{
				$l = 0;
			}
			//how many f in current semester?
			$wresponse=$db->query("	SELECT sum(f_val)
									FROM events_signup 
									LEFT JOIN events_listing
									ON events_signup.event_id = events_listing.event_id
									WHERE events_signup.user_id = $id AND events_signup.semester = '$current_semester'");
			$wres=mysqli_fetch_array($wresponse);
			$f = $wres['sum(f_val)'];
			if ($f == null)
			{
				$f = 0;
			}
			//how many hours in current semester?
			$wresponse=$db->query("	SELECT sum(hours)
									FROM recorded_hours
									WHERE user_id = $id");
			$wres=mysqli_fetch_array($wresponse);
			$s = $wres['sum(hours)'];
			if ($s == null)
			{
				$s = 0;
			}
			//how many committee events?
			$wresponse=$db->query("	SELECT count(events_listing.event_id)
									FROM events_signup 
									LEFT JOIN events_listing
									ON events_signup.event_id = events_listing.event_id
									WHERE events_signup.user_id = $id AND events_signup.semester = '$current_semester' AND events_listing.event_type = 'Taskforce'");
			$wres=mysqli_fetch_array($wresponse);
			$c = $wres['count(events_listing.event_id)'];
			if ($c == null)
			{
				$c = 0;
			}			
			//how many excused?
			$wresponse=$db->query("	SELECT count(event_id)
									FROM excused
									WHERE user_id = $id AND semester = '$current_semester'");
			$wres=mysqli_fetch_array($wresponse);
			$e = $wres['count(event_id)'];
			if ($e == null)
			{
				$e = 0;
			}					
			//how many unexcused?
			 //need to check each event
		$u = 0;
		$theresponse=$db->query("SELECT event_name,event_id FROM events_listing WHERE required=1");

		while($reqevent=mysqli_fetch_array($theresponse))
		{
			//check if attended
			if ( did_user_attend($id,$reqevent['event_id']) )
			{
			}
			//check if excused
			else if ( is_user_excused($id,$reqevent['event_id']) )
			{
			}
			//else unexcused
			else
			{
				$u++;
			}
		}			 
			echo "<td>$l</td><td>$f</td><td>$s</td><td>$c</td><td>$e</td><td>$u</td></tr>";
		}
		?>
		
		</table>
		<?php
		
		//second: status associate
		?>
		<h1>Associate Brothers</h1>
		<table>
		<tr><th>ID</th><th>Name</th><th>Email</th><th>Hours</th></tr>
		
		<?php
		
		//get a list of all associate brother
		$response=$db->query("SELECT id,firstname,lastname,email FROM contact_information WHERE status = 'Associate'");		
		
		while($result=mysqli_fetch_array($response))
		{
			$id = $result['id'];
			$name = $result['firstname'] . " " . $result['lastname'];
			$email = $result['email'];
			
			//how many hours in current semester?
			$wresponse=$db->query("	SELECT sum(hours)
									FROM recorded_hours
									WHERE user_id = $id");
			$wres=mysqli_fetch_array($wresponse);
			$s = $wres['sum(hours)'];
			if ($s == null)
			{
				$s = 0;
			}
			
			echo "<tr><td>$id</td><td>$name</td><td>$email</td><td>$s</td></tr>";
		}
		?>
		
		</table>
		<?php		
		//third: status senior
		?>
		<h1>Senior Brothers</h1>
		<table>
		<tr><th>ID</th><th>Name</th><th>Email</th></tr>
		
		<?php
		
		//get a list of all senior brother
		$response=$db->query("SELECT id,firstname,lastname,email FROM contact_information WHERE status = 'Senior'");		
		
		while($result=mysqli_fetch_array($response))
		{
			$id = $result['id'];
			$name = $result['firstname'] . " " . $result['lastname'];
			$email = $result['email'];
			echo "<tr><td>$id</td><td>$name</td><td>$email</td></tr>";
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
