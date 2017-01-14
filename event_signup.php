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

function display($event_type) {
		include('mysql_access.php');
		$user_id = $_SESSION['sessionID'];

		echo "Displaying " . $event_type . " Events";

		if ($event_type != "All")
		{
			$xresponse=$db->query("SELECT * FROM events_listing WHERE event_type='$event_type' ORDER BY event_name");
		}
		else
		{
			$xresponse=$db->query("SELECT * FROM events_listing ORDER BY event_name");
		}

		while($result=mysqli_fetch_array($xresponse)) 
		{
			$l_id = $result['event_leader_id'];
			$yresponse=$db->query("SELECT email FROM contact_information WHERE id='$l_id'");
			$yresult=mysqli_fetch_array($yresponse);
			$l_email = $yresult['email'];
			$event = $result['event_id'];

			$response=$db->query("SELECT * FROM events_listing WHERE event_id = $event");
			$result=mysqli_fetch_array($response);

			$response=$db->query("SELECT COUNT(user_id) FROM events_signup WHERE event_id = $event");
			$signed=mysqli_fetch_array($response);
			$count = $signed['COUNT(user_id)'];

			$response=$db->query("SELECT user_id FROM events_signup WHERE event_id = $event AND user_id = $user_id");
			$already=mysqli_fetch_array($response);

			//check if full
			if (($result['event_cap'] <= $count) && ($count != 0))
			{
			}
			//check if already signed up
			else if (($already['user_id'] == $user_id) && ($result['repeatable'] == 0))
			{
			}
			//create a table entry
			else
			{
			?>
			<form method="post" action="event_signup_done.php">
				<input type="hidden" name="user" value="<?php echo htmlspecialchars($user_id); ?>">
				<input type="hidden" name="event_name" value="<?php echo htmlspecialchars($result['event_name']); ?>">
				<input type="hidden" name="event_id" value="<?php echo htmlspecialchars($result['event_id']); ?>">
			<table>
			<tr><td><input type="submit" name="submit" value="signup"/></td><td><?= $result['event_type'] ?> Event</td> <th colspan="3"><?= $result['event_name'] ?> </th></tr>
			<tr><td>L Points :</td><td><?= $result['L_val'] ?></td><td>Email:</td><td colspan="2"><?= $l_email ?></td></tr>
			</table>
			</form>
			<?php
			}
		}
}

function show_active() {
	$user_id = $_SESSION['sessionID'];
	include('mysql_access.php');
	$page = null;
	//sets event info section from selection
	$event_type = "none";
	echo "<h1>Event Signups</h1>";
	echo "<a href='check_requirements.php'>Check your requirements here.</a>";
	if(isset($_POST['type_set']))
	{
		$event_type = $_POST['type_set'];
	}
		?>
		<form name="myform" action="" method="post">
		<select name='type_set' onchange="this.form.submit()">
			<option value='null' selected>-- select event type --</option>
			<option value='All'>All</option>
			<option value='Chapter'>Chapter / Point</option>
			<option value='Taskforce'>Taskforce</option>
			<option value='Large Service'>Large Service</option>
			<!-- <option value='Other'>Other</option> !-->
		</select>
		</form>
		<?php
		display($event_type);
}

?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
