<?php
$result = '';
require_once ('layout.php');
require_once ('mysql_access.php');
global $current_semester;
global $previous_semester;
	$id = $_SESSION['sessionID'];
function add_new_event() {
	$event = $_POST['event'];
	$description = $_POST['description'];
	
	global $current_semester;
	
	$description = htmlspecialchars($description, ENT_QUOTES);
	
	if($description == NULL){
		$result = "You didn't fill out the form completely.<br/>";
	}
	else {
		$insert = "INSERT INTO apo.events_list (event, description, semester) VALUES('$event','$description','$current_semester')";
		$query = mysql_query($insert) or die ("If you encounter problems, please contact the webmaster.");
		$result = '1';
		echo("You have added an event and the webmaster will be notified shortly.");
		}
END;
return $result;
}
	
function process_form() {	
	$id = $_SESSION['sessionID'];
	$event = $_POST['event'];
	$description = $_POST['description'];
	$semester = $_POST['semester'];

	$description = htmlspecialchars($description, ENT_QUOTES);

		$insert = "INSERT INTO apo.recorded_events (user_id, event, description, semester) values('$id', '$event', '$description', '$semester');";
		$query2 = mysql_query($insert) or die("If you encounter problems, please contact the webmaster.");
		$result = '1';
				
END;	
	
return $result;
}


function list_events($id) {	// modify this function to list the events that have been completed. 
	$sql = "SELECT * FROM `recorded_events` WHERE `user_id` = $id";
	$results = mysql_query($sql) or die("Something went wrong, please contact the webmaster");
	
	echo "<div style='margin: 0px auto; width: 100%; text-align: center;'>
	<table cellpadding='0' cellspacing='0' class='hours_table'>
	<tr class='hours_header'><td>Event</td><td>Description</td><td>Semester</td><td></td></tr>";
	$inc = 1;
	while ($i = mysql_fetch_array($results)) {
		if (($inc % 2) == 1) {
			$hours_line = "class='hours_row1'";
		} else {
			$hours_line = "class='hours_row2'";
		}
		
		echo "<tr $hours_line><td width='40%'>$i[event]</td>
		<td> $i[description] </td>
		<td width='15%'>$i[semester]</td>
		<td><sup><a href='Beads.php?delete=$i[index]'>Delete?</a></sup></td>
		</tr>";
		
		$inc = $inc + 1;
	}
	echo "</table></div>";
}


if (isset($_POST['action']) && $_POST['action'] == "log_event") {
	$result = process_form();
	if ($result == 1)
	{
		header('Location: http://apo.truman.edu/Beads.php' );
	}

}
function delete_hour($id, $user_id) {
	$sql = "DELETE FROM `recorded_events` WHERE `index` = '$id' AND `user_id` = '$user_id' LIMIT 1";
	$result = mysql_query($sql) or exit("There was an error, contact Webmaster");
}

if (isset($_GET['delete'])) {
	$user_id = $_SESSION['sessionID'];
	$id = $_GET['delete'];
	
	delete_hour($id, $user_id);
}

page_header();

?>


<link rel="stylesheet"
   type="text/css"
   media="print" href="http://apo.truman.edu/layout_files/print_styles.css" />


<div class="content">


<?php
if (!isset($_SESSION['sessionID'])) {

		echo "<p>You need to login before you can see the rest of this section.</p>"; 

} elseif ($_SESSION['sessionID'] == 'Advisor' OR $_SESSION['sessionID'] == 'Alumni') {
		echo "<p>You need cannot log hours with the account you have logged in with.  Please contact the webmaster if you need help.";
} else {
		
echo $result;


global $previous_semester;
global $current_semester;
global $next_semester;

echo<<<END
<h1>Bead Events</h1>

</div>

<div style="clear:both;"></div>


<div id="service_bar">
<table><tr><td rowspan='2' valign='top'>
<div id="service_log">
<h2>Log Event</h2> 
<form action="Beads.php" class="form" id="new_volunteer_time" method="post">
<p>
	<label for="volunteer_time_event">Event</label> 
  		<select id="volunteer_time_event" name="event">
  			<option value="A">A</option> 
			<option value="B">B</option> 
		</select> 
</p> 
<p>
	<label for="description">Description</label> 
  		<input name="description" size="30" type="text" /> 
</p> 
<p>
	<label for="semester">Semester</label> 
  		<select name="semester">
  			<option selected="selected">$current_semester</option>
  			</select>
</p> 
<p align="center">
		<input type='hidden' name='action' value='log_event'/>
		<input type='submit' value='Log Event' style='font-weight:bold;'/>

</p> 
</form> 
</div>
</td>

<td>
<div id="service_requirements">
<h2>Qualifying Events</h2>

Camp, etc. 
</div>
</td></tr>
<tr><td>
<div id="service_stats">
<h2>Current Events for $current_semester</h2>
Here a list of events w/ dates could be listed.
</div>
</td></tr>
</table>
</div>

<div style="clear:both;"></div>
<div class="content">
END;
	
list_events($_SESSION[sessionID]);

}
?>
</div>

<?php

page_footer();

?>