<?php

function newEventForm(){
echo<<<FORM
	<h2>Add an Event</h2>
	Please enter the name of the new event below:<br/>
	<form method="post" action="$_SERVER[PHP_SELF]">
		<input type="text" name="projectName"></input>
		<input type="hidden" name="newEventFormSubmit" value="continue"/>
		<input type='submit' name="submit" value='Submit'/>
	</form>
FORM;
}
function removeEventForm(){
	
	echo "<h2>Remove an Event</h2>";
	echo "<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">";
	echo "<select name=\"event\">";
	$sql = "SELECT e.name AS name, d.detail_id AS detail_id, d.event_id AS id, 
				d.DOW AS DOW, d.start AS start, d.end AS end
			FROM service_events AS e
			JOIN service_details AS d
			ON e.P_Id = d.event_id
			ORDER BY id";
	$query = mysql_query($sql) or die("error".mysql_error());
	while ($r = mysql_fetch_array($query)) {
		echo "<option value='$r[detail_id]'>{$r[name]}: {$r[DOW]} {$r[start]}-{$r[end]}</option>";
	}
	echo "</select>";
echo <<<FORM
	<input type="hidden" name="removeEventFormSubmit" value="continue"/>
		<input type='submit' name="submit" value='Submit'/>
	</form>
FORM;

}
function editEventForm(){
	
	echo "<h2>Edit an Event</h2>";
	echo "<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">";
	echo "<select name=\"event\">";
	$sql = "SELECT e.name AS name, d.detail_id AS detail_id, d.event_id AS id, 
				d.DOW AS DOW, d.start AS start, d.end AS end
			FROM service_events AS e
			JOIN service_details AS d
			ON e.P_Id = d.event_id
			ORDER BY id";
	$query = mysql_query($sql) or die("error".mysql_error());
	while ($r = mysql_fetch_array($query)) {
		echo "<option value='$r[detail_id]'>{$r[name]}: {$r[DOW]} {$r[start]}-{$r[end]}</option>";
	}
	echo "</select>";
echo <<<FORM
	<input type="hidden" name="editEventFormSubmit" value="continue"/>
		<input type='submit' name="submit" value='Submit'/>
	</form>
FORM;

}
function eventDetailsForm(){
	echo "<h2>Add Event Details</h2>";
	
echo<<<FORM
	<table width="300">
	<form method="POST" action="$_SERVER[PHP_SELF]">
	<tr><td width="40%">Select project name: </td><td><select name="event_id">
FORM;
	$sql = "SELECT `P_Id`, `name` FROM `service_events` ORDER BY `P_Id`";
	$query = mysql_query($sql) or die("Error: line 29");
	while ($r = mysql_fetch_array($query)) {
		echo "<option value='$r[P_Id]'>$r[name]</option>";
	}
	echo "</select><br/></td></tr>";
echo<<<FORM
		<tr><td width="40%">Day of the week: 
		</td><td><select name="DOW">
			<option value=""></option>
			<option value="Monday">Monday</option>
			<option value="Tuesday">Tuesday</option>
			<option value="Wednesday">Wednesday</option>
			<option value="Thursday">Thursday</option>
			<option value="Friday">Friday</option>
			<option value="Saturday">Saturday</option>
			<option value="Sunday">Sunday</option>
		</select><br/></td></tr>
		<tr><td width="40%">start time: </td><td><input type='time' name='start'/><br/></td></tr>
		<tr><td width="40%">end time: </td><td><input type='time' name='end'/><br/></td></tr>
		<tr><td width="40%">default hours: </td><td><input type='text' name='length'/><br/></td></tr>
		<tr><td width="40%">default max: </td><td><input type='text' name='max'/><br/></td></tr>
	<tr><td width="100%">
	<input type="hidden" name="eventDetailsFormSubmit" value="continue"/>
	<input type='submit' name="submit" value='Submit'/></td></tr>
	</table>
	</form>
FORM;
}

function assignPLForm(){
	echo "<h2>Assign Project Leader (Limit 1)</h2>";
	echo <<<FORM
	<form method="post" action="$_SERVER[PHP_SELF]">
		<select name='user_id'>
FORM;
	$sql = "SELECT `id`, `firstname`, `lastname` FROM `contact_information` ORDER BY `lastname`";
	$query = mysql_query($sql) or die("Error: line 24");
	while ($r = mysql_fetch_array($query)) {
		echo "<option value='$r[id]'>$r[lastname], $r[firstname]</option>";
	}
	echo "</select>";
	echo "<select name=\"event\">";
	$sql = "SELECT e.name AS name, d.detail_id AS detail_id, d.event_id AS id, 
				d.DOW AS DOW, d.start AS start, d.end AS end
			FROM service_events AS e
			JOIN service_details AS d
			ON e.P_Id = d.event_id
			ORDER BY id";
	$query = mysql_query($sql) or die("error".mysql_error());
	while ($r = mysql_fetch_array($query)) {
		echo "<option value='$r[detail_id]'>{$r[name]}: {$r[DOW]} {$r[start]}-{$r[end]}</option>";
	}
	echo "</select>";
echo <<<FORM
	<input type="hidden" name="assignPLFormSubmit" value="continue"/>
		<input type='submit' name="submit" value='Submit'/>
	</form>
FORM;

}
function editEventForm2(){
	
	echo "<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">";
	echo "<select name=\"event\">";
	$sql = "SELECT * FROM service_events ORDER BY name";
	$query = mysql_query($sql) or die("error".mysql_error());
	while ($r = mysql_fetch_array($query)) {
		echo "<option value='$r[P_Id]'>{$r[name]}</option>";
	}
	echo "</select>";
echo <<<FORM
	<input type="hidden" name="editEventFormSubmit2" value="continue"/>
		<input type='submit' name="submit" value='edit'/>
	</form>
FORM;

}
?>









