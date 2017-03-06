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

function delete_event($entry) {
  include ('mysql_access.php');
  $sql = "DELETE FROM `events_signup` WHERE `entry_id` = '$entry' LIMIT 1";
  $delete = $db->query($sql) or exit("There was an error, contact Webmaster");
}

function print_daily($day) {

	include('mysql_access.php');

	$gen=$db->query("SELECT * FROM events_listing WHERE event_type='Regular' ORDER BY event_name");
	while($general=mysqli_fetch_array($gen)) 
	{
		$show = true;
		$uid = $_SESSION['sessionID'];
	
		$id = $general['event_id'];
		$d_lead = $general['event_leader_id'];

		$wresponse=$db->query("SELECT week_cd FROM week LIMIT 1");
		$wres=mysqli_fetch_array($wresponse);
		$week_cd = $wres['week_cd'];

		$dsearch=$db->query("SELECT * FROM regular_service_details WHERE event_id=$id");
		$daily=mysqli_fetch_array($dsearch);

		$lsearch=$db->query("SELECT firstname,lastname,phone FROM contact_information WHERE id=$d_lead");
		$leader_d=mysqli_fetch_array($lsearch);

		$cancel = $daily['cancel'];
		$close = $daily['closed'];

		if (($daily[$day] == 1) && (!$cancel) && (!$close)) 
		{			
			//print details
			$d_time = $daily['time'];
			$name = $general['event_name'];	
			$S_val = $general['S_val'];
			$d_desc = $general['event_description'];
			$l_name = $leader_d['firstname'] . " " . $leader_d['lastname'];
			$l_num = $leader_d['phone'];
echo <<<END
					<p><table>
					<tr><th colspan=3>$name</th></tr>
					<tr><td colspan=2>$d_time</td><td>Hours : $S_val</td></tr>
					<tr><td colspan=3>$d_desc</td></tr>
					<tr><td>$l_name</td><td>$l_num</td><td>Drive?</td></tr>
END;
			//go through capacity
			$cap = $general['event_cap'];
			for ( $c=1; $c<=$cap; $c++ )
			{	
					//print info for this event, factor c
					$fsearch=$db->query("SELECT user_id,drive,entry_id FROM events_signup WHERE event_id=$id AND Factor=$c AND week=$week_cd AND day='$day'");
					$factor=mysqli_fetch_array($fsearch);
					
					if(isset($factor['user_id']))
					{
						//allow delete
						$fid = $factor['user_id'];
						if ($uid == $fid)
						{
						$entr_id = $factor['entry_id'];
						$info=$db->query("SELECT firstname,lastname,phone FROM contact_information WHERE id=$fid");
						$i=mysqli_fetch_array($info);
						$i_num = "<sup><a href='event_signup.php?delete=$entr_id'>Delete?</a></sup>";
						$i_name = $i['firstname'] . " " . $i['lastname'];
						$i_drive = $factor['drive'];							
						}
						else	
						{
						$info=$db->query("SELECT firstname,lastname,phone FROM contact_information WHERE id=$fid");
						$i=mysqli_fetch_array($info);
						$i_num = $i['phone'];
						$i_name = $i['firstname'] . " " . $i['lastname'];
						$i_drive = $factor['drive'];
						}
					}
					else
					{
						$already=$db->query("SELECT user_id FROM events_signup WHERE event_id=$id AND week=$week_cd AND day='$day' AND user_id=$uid");
						$a_sign=mysqli_fetch_array($already);

						if (isset($a_sign['user_id'])) 
						{ 
							$show = false; 
						}

						if ($show)
						{
						$eid = $id;
						$ename = $general['event_name'];
						$i_num = "";
						$i_name= '
			<form method="post" action="event_signup_done.php">
				<input type="hidden" name="user" value=' . $uid . '>
				<input type="hidden" name="event_name" value=' . $ename . '>
				<input type="hidden" name="event_id" value=' . $eid . '>
				<input type="hidden" name="Factor" value=' . $c . '>
				<input type="hidden" name="day" value=' . $day . '>
				<input type="hidden" name="week" value=' . $week_cd . '>
				<input type="submit" name="submit" value="signup"/>';
						$i_drive = "<input type='text' name='drive' value='no'></form>";
						$show = false;
						}
						else
						{
						$i_name = "open";
						$i_num = "";
						$i_drive = "";
						}
					}
					echo "<tr><td>$c. $i_name</td><td>$i_num</td><td>$i_drive</td></tr>";
			}
echo <<<END
					</table>
					</p>
END;
		}

	}

}

function display($event_type) {
		include('mysql_access.php');
		$user_id = $_SESSION['sessionID'];

		echo "Displaying " . $event_type . " Events";

		if ($event_type == "Regular")
		{
			$wresponse=$db->query("SELECT week_cd FROM week LIMIT 1");
			$wres=mysqli_fetch_array($wresponse);
			$week_cd = $wres['week_cd'];

			switch($week_cd) {
				case 1:
					$week = "1/15/2017";
					break;
				case 2:
					$week = "1/22/2017";
					break;
				case 3:
					$week = "1/29/2017";
					break;
				case 4:
					$week = "2/5/2017";
					break;
				case 5:
					$week = "2/12/2017";
					break;
				case 6:
					$week = "2/19/2017";
					break;
				case 7:
					$week = "2/26/2017";
					break;
				case 8:
					$week = "3/5/2017";
					break;
				case 9:
					$week = "3/12/2017";
					break;
				case 10:
					$week = "3/19/2017";
					break;
				case 11:
					$week = "3/26/2017";
					break;
				case 12:
					$week = "4/2/2017";
					break;
				case 13:
					$week = "4/9/2017";
					break;
				case 14:
					$week = "4/16/2017";
					break;
				case 15:
					$week = "4/23/2017";
					break;
				case 16:
					$week = "4/30/2017";
					break;
				case 17:
					$week = "5/7/2017";
					break;
				case 18:
					$week = "5/14/2017";
					break;
			}
			?>
			<h2>Week of <?php echo $week ?><h2>

			<div id='day'>

			<?php
			//get general details
			echo "<h3>Sunday</h3>";
			print_daily('sunday');
			echo "<h3>Monday</h3>";
			print_daily('monday');
			echo "<h3>Tuesday</h3>";
			print_daily('tuesday');
			echo "<h3>Wednesday</h3>";
			print_daily('wednesday');
			echo "<h3>Thursday</h3>";
			print_daily('thursday');
			echo "<h3>Friday</h3>";
			print_daily('friday');
			echo "<h3>Saturday</h3>";
			print_daily('saturday');

		}
		else
		{

		if ($event_type != "All")
		{
			$xresponse=$db->query("SELECT * FROM events_listing WHERE event_type='$event_type' ORDER BY event_name");
		}
		else
		{
			$xresponse=$db->query("SELECT * FROM events_listing WHERE event_type='Regular' ORDER BY event_name");
		}

		while($result=mysqli_fetch_array($xresponse)) 
		{
			$l_id = $result['event_leader_id'];

			$yresponse=$db->query("SELECT firstname,lastname,email FROM contact_information WHERE id='$l_id'");
			$yresult=mysqli_fetch_array($yresponse);

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
			//check if closed
			else if ($result['closed'] == 1)
			{
				
			}
			//create a table entry
			else
			{
			
				if ($result['event_type'] == 'Chapter')
				{
					//pull rec sec info
					$vesponse=$db->query("SELECT firstname,lastname,email FROM contact_information WHERE position = 'Recording Secretary' LIMIT 1");
					$vesult=mysqli_fetch_array($vesponse);
					$l_name = $vesult['firstname'] . " " . $vesult['lastname'];
					$l_email = $vesult['email'];
				}
				else
				{
					$l_name = $yresult['firstname'] . " " . $yresult['lastname'];
					$l_email = $yresult['email'];
				}
			?>
			<form method="post" action="event_signup_done.php">
				<input type="hidden" name="user" value="<?php echo htmlspecialchars($user_id); ?>">
				<input type="hidden" name="event_name" value="<?php echo htmlspecialchars($result['event_name']); ?>">
				<input type="hidden" name="event_id" value="<?php echo htmlspecialchars($result['event_id']); ?>">
			<table>
			<tr><td><input type="submit" name="submit" value="signup"/></td><th><?= $result['event_type'] ?> Event : <?= $result['event_name'] ?></th> <td colspan="3">Leader : <?= $l_name ?> </td></tr>
			<tr><td><?= $result['event_time'] ?></td><td><?= $result['event_description'] ?></td><td>Email:</td><td colspan="2"><?= $l_email ?></td></tr>
			</table>
			</form>
			<?php
			}
		}
		}
}

function show_active() {
	$user_id = $_SESSION['sessionID'];
	include('mysql_access.php');

	if (isset($_GET['delete'])) {
		$entr_id = $_GET['delete'];
		delete_event($entr_id);
	}

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
			<!--<option value='Regular'>Regular Service</option>
			<option value='Large Service'>Large Service</option>
			<option value='Other'>Other</option> !-->
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
