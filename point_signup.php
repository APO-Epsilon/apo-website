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
    <!-- PHP method to include header -->
<div class="row">

<?php
$exec_page = False;
$active_page = True;
$public_page = False;
require_once('permissions.php');

function show_active() {
	$user_id = $_SESSION['sessionID'];
	include('mysql_access.php');
    $response=$db->query("SELECT * FROM events_listing WHERE event_type='Chapter' ORDER BY event_id ");
	echo "<h1> Chapter Signups </h1>";
	echo "Add events to your points!<br>";
	echo "<a href='check_requirements.php'>Check your requirements here.</a>";
    $tresponse=$db->query("SELECT * FROM events_listing WHERE event_type='Chapter' AND L_val > 0 ORDER BY event_name ");
	
	echo "<h1>LEADERSHIP POINTS</h1>";
	echo "<table>";
	echo "<tr><td>Event Name</td><td>Event Type</td><td>Leadership</td><td>Signup</td></tr>";
			while($tresult=mysqli_fetch_array($tresponse)) 
			{
				
				$eid = $tresult['event_id'];
				$e_name = $tresult['event_name'];
				?>
				<form method="post" action="point_signup_done.php">
				<input type="hidden" name="user" value="<?php echo htmlspecialchars($user_id); ?>">
				<input type="hidden" name="event_name" value="<?php echo htmlspecialchars($e_name); ?>">
				<input type="hidden" name="event_id" value="<?php echo htmlspecialchars($eid); ?>">
				<tr><th><?= $e_name ?></th><td><?= $tresult['event_type'] ?></td>
				<td><?= $tresult['L_val'] ?></td>
				<td><input type="submit" name="submit" value="signup"/></td></tr>
				</form>
				<?php
			}
	echo "</table>";
	
    $fresponse=$db->query("SELECT * FROM events_listing WHERE event_type='Chapter' AND F_val > 0 ORDER BY event_name ");
	echo "<h1>FRIENDSHIP POINTS</h1>";		
	echo "<table>";
	echo "<tr><td>Event Name</td><td>Event Type</td><td>Friendship</td><td>Signup</td></tr>";
			while($fresult=mysqli_fetch_array($fresponse)) 
			{
				$eid = $fresult['event_id'];
				$e_name = $fresult['event_name'];
				?>
				<form method="post" action="point_signup_done.php">
				<input type="hidden" name="user" value="<?php echo htmlspecialchars($user_id); ?>">
				<input type="hidden" name="event_name" value="<?php echo htmlspecialchars($e_name); ?>">
				<input type="hidden" name="event_id" value="<?php echo htmlspecialchars($eid); ?>">
				<tr><th><?= $e_name ?></th><td><?= $fresult['event_type'] ?></td>
				<td><?= $fresult['F_val'] ?></td>
				<td><input type="submit" name="submit" value="signup"/></td></tr>
				</form>
				<?php
			}
	echo "</table>";
}

//old code that checks for capacity and repeated entries
function display($event) {
	if ($event != 0)
	{	
		include('mysql_access.php');
		$user_id = $_SESSION['sessionID'];
		$response=$db->query("SELECT * FROM events_listing WHERE event_id = $event");
		$result=mysqli_fetch_array($response);
		$response=$db->query("SELECT COUNT(user_id) FROM events_signup WHERE event_id = $event");
		$signed=mysqli_fetch_array($response);
		$response=$db->query("SELECT user_id FROM events_signup WHERE event_id = $event AND user_id = $user_id");
		$already=mysqli_fetch_array($response);
		echo $result['event_name'] . " " . $result['event_time'] . " " . $result['event_place'] . "<br>";
		//don't allow signup if the user is already signed up
		if ($already['user_id'] == $user_id && $result['repeatable'] == 0)
		{
			echo "You're already signed up for this category!";
		}
		//elaborate on event
		else
		{
			echo "Click to signup!";
		}
	}
	else
	{
		echo "Choose a service event!";
	}
}
?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
