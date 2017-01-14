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

function open_signin($instance) {
	include('mysql_access.php');
	$uresponse=$db->query("SELECT event_name FROM events_listing WHERE event_id = $instance");
	$uresult=mysqli_fetch_array($uresponse);
	$name = $uresult['event_name'];

	echo "<h2>" . $name . "</h2>";
	//allow one person to sign in
	?>
		<form form name="signin" action="" method="post">
			<input type="hidden" name="instance" value=<?= $instance ?>>
			<p>User Id:<input type="number" name="next_user_id" style="width: 7em">
			</p><p>
			<input type="submit" name="submit" value="Sign In"/></p>
		</form>
	<?php
}

function display_attendees($eid){
	?>
	<h2>Attendees</h2>
	<table>
		<tr><th>#</th><th>Name</th></tr>
	<?php
		include('mysql_access.php');
		//loop for each participant. Display name
		$count = 0;
		$aresponse=$db->query("SELECT user_id FROM events_signup WHERE event_id = $eid");
		while($aresult=mysqli_fetch_array($aresponse))
		{
			$count++;
			$uid = $aresult['user_id'];
			$uresponse=$db->query("SELECT firstname,lastname FROM contact_information WHERE id = $uid");
			$uresult=mysqli_fetch_array($uresponse);
			echo "<tr><td>" . $count . "</td><td>" . $uresult['lastname'] . ", " . $uresult['firstname'] . "</td></tr>";
		}
	?>		
	</table>
	<?php
}

function show_active() {
	//dropdown list of events
	?>
	<h1> Attendance Check-In </h1>
		<?php
	include('mysql_access.php');
	$user_id = $_SESSION['sessionID'];	
	$aresponse=$db->query("SELECT position FROM contact_information WHERE id=$user_id");
	$aresult=mysqli_fetch_array($aresponse);
	$position = $aresult['position'];
	if ($position == "Webmaster" || $position == "Recording Secretary") {
		$page = null;
		//sets event info section from selection
		$instance = "none";
		if(isset($_POST['instance']))
		{
			$instance = $_POST['instance'];
		}
		if($instance == "none")
		{
			$xresponse=$db->query("SELECT * FROM events_listing WHERE event_type='Attendance' ORDER BY event_name");
			?>
			<form name="instance_choice" action="" method="post">
				<select name='instance' onchange="this.form.submit()">
					<option value='null' selected>-- select one --</option>
					<?php
					while($result=mysqli_fetch_array($xresponse)) 
					{
						echo "<option value='" . $result['event_id'] . "'>" . $result['event_name'] . "</option>";
					}
					?>
			</select>
			</form>
			<?php
		}
		else
		{
			if(isset($_POST['next_user_id']))
			{
				$nuid = $_POST['next_user_id'];

				//if not already, add $nuid to signin
				$check=$db->query("SELECT user_id FROM events_signup WHERE event_id=$instance");
				$mark = false;
				while($bresult=mysqli_fetch_array($check)) 
				{
					if ($bresult['user_id'] == $nuid)
					{
						$mark = true;
					}
				}
				if (!$mark)
				{
					$statement ="INSERT INTO events_signup (user_id,event_id) VALUES ($nuid,$instance)";
					$result = $db->query($statement) or die("could not update");
				}			
				else
				{
					echo "<p>You are already signed in!</p>";
				}
			}
			open_signin($instance);
			display_attendees($instance);
		}	
	}
	else 
	{
		echo "Only the recording secretary can open attendance.";
	}
	
}


?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
