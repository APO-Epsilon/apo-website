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

function display($event_type) {
		include('mysql_access.php');
		$user_id = $_SESSION['sessionID'];	
		$response=$db->query("SELECT MAX(event_id) FROM events_listing");
		$result=mysqli_fetch_array($response);
		$next = $result['MAX(event_id)'] + 1;
		if ($event_type=='Other')
		{
			?>
			<h2>Create Other Event</h2>
			<form name="myform" action="create_event_done.php" method="post">
				<input type='hidden' name='event_type' value='<?= $event_type ?>'>
				<input type='hidden' name='event_id' value=<?= $next ?>>
				<p>Event Title:
				<input type="text" name="event_name" required></p>
				<p>Leadership Points:
				<input type="number" step="0.25" name="L_val" value="0"></p>
				<p>Friendship Points:
				<input type="number" step="0.25" name="F_val" value="0"></p>
				<p>Service Points:
				<input type="number" step="0.25" name="S_val" value="0"></p>
				<p>Date: (leave blank if not applicable)
				<input type='date' name='event_time' value=0></p>
				<p>Meeting Location:
				<input type='text' name='event_place' value='Circle Drive'></p>
				<p>Description:<p>
				<input type="text" name="event_description"></p>
				<p>Event Cap: (use 0 if there is no cap)
				<input type="number" name="event_cap" value="0"></p>
				<p>Event Leader ID: (defaults to your ID)
				<input type='number' name='event_leader_id' value=<?= $user_id ?>></p>
				<p>Repeatable?
				<input type="checkbox" name="repeatable"></p>
				<p>Required?
				<input type="checkbox" name="required"></p>
				<p>
				<input type="submit" name="submit" value="create"/></p>
			</form>
			<?php
		}
		else if ($event_type=='Attendance') {
			?>	
			<h2>Create Attendance Event</h2>
			<form name="myform" action="create_event_done.php" method="post">
				<input type='hidden' name='event_type' value='<?= $event_type ?>'>
				<input type='hidden' name='event_id' value=<?= $next ?>>
				<p>Event Title:
				<input type="text" name="event_name" required></p>
				<input type="hidden" step="0.25" name="L_val" value="0"></p>
				<input type="hidden" step="0.25" name="F_val" value="0"></p>
				<p>Service Points:
				<input type="number" step="0.25" name="S_val" value="0"></p>
				<p>Date: (leave blank if not applicable)
				<input type='date' name='event_time' value=0></p>
				<p>Meeting Location:
				<input type='text' name='event_place' value='Circle Drive'></p>
				<p>Description:<p>
				<input type="text" name="event_description"></p>
				<input type="hidden" name="event_cap" value="0"></p>
				<p>Event Leader ID: (defaults to your ID)
				<input type='number' name='event_leader_id' value=<?= $user_id ?>></p>
				<p>Repeatable?
				<input type="checkbox" name="repeatable"></p>
				<p>Required?
				<input type="checkbox" name="required"></p>
				<p>
				<input type="submit" name="submit" value="create"/></p>
			</form>
			<?php
		}
		else if ($event_type=='Regular') {
			?>	
			<h2>Create Regular Service Event</h2>
			<form name="myform" action="create_event_done.php" method="post">
				<input type='hidden' name='event_type' value='<?= $event_type ?>'>
				<input type='hidden' name='event_id' value=<?= $next ?>>
				<p>Event Title:
				<input type="text" name="event_name" required></p>
				<input type="hidden" step="0.25" name="L_val" value="0"></p>
				<input type="hidden" step="0.25" name="F_val" value="0"></p>
				<p>Service Points:
				<input type="number" step="0.25" name="S_val" value="0"></p>
				<input type='hidden' name='event_time' value=0>

				<p> Occurence Information: </p>
				<p> 0 : never on this day </p>
				<p> 1 : weekly </p>
				<p> 2 : every other week </p>
				<p> 3 : irregular (monthly, etc) talk to webmaster after selecting<p>
				<p> Sunday
				<input type='number' name='sunday' value=0></p>
				<p> Monday
				<input type='number' name='monday' value=0></p>
				<p> Tuesday
				<input type='number' name='tuesday' value=0></p>
				<p> Wednesday
				<input type='number' name='wednesday' value=0></p>
				<p> Thursday
				<input type='number' name='thursday' value=0></p>
				<p> Friday
				<input type='number' name='friday' value=0></p>
				<p> Saturday
				<input type='number' name='saturday' value=0></p>

				<p>Time
				<input type='text' name='time' value=0></p>

				<p>Meeting Location:
				<input type='text' name='event_place' value='Circle Drive'></p>
				<p>Description:
				<input type="text" name="event_description"></p>
				<p>Service Type:
				<input type="text" name="service_type"></p>
				<p>Event Cap: (use 0 if there is no cap) do not include project leader
				<input type="number" name="event_cap" value="0"></p>
				<p>Event Leader ID: (defaults to your ID)
				<input type='number' name='event_leader_id' value=<?= $user_id ?>></p>
				<p>Repeatable?
				<input type="checkbox" name="repeatable"></p>
				<p>Required?
				<input type="checkbox" name="required"></p>
				<p>Youth?
				<input type="checkbox" name="youth"></p>
				<p>
				<input type="submit" name="submit" value="create"/></p>
			</form>
			<?php
		}
		else if ($event_type=='Large') {
			?>	
			<h2>Create Large Service Event</h2>
			<form name="myform" action="create_event_done.php" method="post">
				<input type='hidden' name='event_type' value='<?= $event_type ?>'>
				<input type='hidden' name='event_id' value=<?= $next ?>>
				<p>Event Title:
				<input type="text" name="event_name" required></p>
				<input type="hidden" step="0.25" name="L_val" value="0"></p>
				<input type="hidden" step="0.25" name="F_val" value="0"></p>
				<p>Service Points:
				<input type="number" step="0.25" name="S_val" value="0"></p>
				<p>Date: (leave blank if not applicable)
				<input type='date' name='event_time' value=0></p>
				<p>Meeting Location:
				<input type='text' name='event_place' value='Circle Drive'></p>
				<p>Description:<p>
				<input type="text" name="event_description"></p>
				<p>Event Cap: (use 0 if there is no cap)
				<input type="number" name="event_cap" value="0"></p>
				<p>Event Leader ID: (defaults to your ID)
				<input type='number' name='event_leader_id' value=<?= $user_id ?>></p>
				<p>Repeatable?
				<input type="checkbox" name="repeatable"></p>
				<p>Required?
				<input type="checkbox" name="required"></p>
				<p>
				<input type="submit" name="submit" value="create"/></p>
			</form>
			<?php
		}
		else if ($event_type=='Taskforce') {
			$task_desc = "Help an exec member!";
			?>	
			<h2>Create Taskforce Event</h2>
			<form name="myform" action="create_event_done.php" method="post">
				<input type='hidden' name='event_type' value='<?= $event_type ?>'>
				<input type='hidden' name='event_id' value=<?= $next ?>>
				<p>Event Title:
				<input type="text" name="event_name" required></p>
				<p>Leadership Points:
				<input type="number" step="0.25" name="L_val" value="0"></p>
				<input type="hidden" step="0.25" name="F_val" value="0"></p>
				<p>Service Points:
				<input type="number" step="0.25" name="S_val" value="0"></p>
				<p>Date: (leave blank if not applicable)
				<input type='date' name='event_time' value=0></p>
				<p>Meeting Location:
				<input type='text' name='event_place' value='Circle Drive'></p>
				<p>Description:<p>
				<input type="text" name="event_description" value=<?= $task_desc ?>></p>
				<p>Event Cap: (use 0 if there is no cap)
				<input type="number" name="event_cap" value="0"></p>
				<input type='hidden' name='event_leader_id' value=<?= $user_id ?>></p>
				<p>Repeatable?
				<input type="checkbox" name="repeatable"></p>
				<p>
				<input type="submit" name="submit" value="create"/></p>
			</form>
			<?php
		}
		else if ($event_type=='Chapter') {
			$rresponse=$db->query("SELECT id FROM contact_information WHERE position='Recording Secretary'");
			$rresult=mysqli_fetch_array($rresponse);
			$rec_id = $rresult['id'];
			?>	
			<h2>Create Chapter Event</h2>
			<form name="myform" action="create_event_done.php" method="post">
				<input type='hidden' name='event_type' value='Chapter'>
				<input type='hidden' name='event_id' value=<?= $next ?>>
				<p>Event Title:
				<input type="text" name="event_name" required></p>
				<input type="hidden" step="0.25" name="L_val" value="0"></p>
				<input type="hidden" step="0.25" name="F_val" value="0"></p>
				<input type="hidden" step="0.25" name="S_val" value="0"></p>
				<p>Date: (leave blank if not applicable)
				<input type='date' name='event_time' value=0></p>
				<p>Meeting Location:
				<input type='text' name='event_place' value='Circle Drive'></p>
				<p>Description:<p>
				<input type="text" name="event_description"></p>
				<p>Event Cap: (use 0 if there is no cap)
				<input type="number" name="event_cap" value="0"></p>
				<input type='hidden' name='event_leader_id' value=<?= $rec_id ?>></p>
				<p>Repeatable?
				<input type="checkbox" name="repeatable"></p>
				<p>Required?
				<input type="checkbox" name="required"></p>
				<p>
				<input type="submit" name="submit" value="create"/></p>
			</form>
			<?php
		}
}

function show_active() {
	?>
	<h1> Event Creation Home </h1>
		<?php
	include('mysql_access.php');
	$user_id = $_SESSION['sessionID'];	
	$aresponse=$db->query("SELECT status FROM contact_information WHERE id=$user_id");
	$aresult=mysqli_fetch_array($aresponse);
	$status = $aresult['status'];
	if ($status == 'Appointed' || $status == 'Elected') {
		$page = null;
		//sets event info section from selection
		$event_type = "none";
		if(isset($_POST['type_set']))
		{
			$event_type = $_POST['type_set'];
		}
		$response=$db->query("SELECT COUNT(event_id) FROM events_listing");
		$result=mysqli_fetch_array($response);
		$next = $result['COUNT(event_id)'] + 1;
		?>
		<p>Event Type:
		<form name="myform" action="" method="post">
		<select name='type_set' onchange="this.form.submit()">
			<option value='null' selected>-- select one --</option>
			<option value='Chapter'>Chapter</option>
			<option value='Attendance'>Attendance</option>
			<option value='Taskforce'>Taskforce</option>
			<!--<option value='Regular'>Regular Service</option>
			<option value='Large'>Large Service</option>
			<option value='Other'>Other</option>!-->
		</select>
		</form>
		<?php
		display($event_type);
	}
	else 
	{
		echo "You cannot create events because you are not on Exec.";
	}
}



?>
</div>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>
