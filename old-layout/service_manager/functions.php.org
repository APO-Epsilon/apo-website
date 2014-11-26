<?php
/*

sessionUsername
sessionFirstname
sessionLastname
sessionexec
sessionposition
sesionID
active_sem

*/

/*
	Add corresponding schedule add and delete etc.
*/

/* assign a user from contact info table project leader status */
function create_leader(){
	$user_id = $_POST['user_id'];
	$schedule_id = $_POST['schedule_id'];
	$query = "INSERT INTO service_leaders
			  (schedule_id, user_id)
			  VALUES (".$schedule_id.",".$user_id.")";
	$result = mysql_query($query);
 }
/* create a service event on the service events table */
function create_events(){
	$event_id = $_POST['event_id'];
	$query = "INSERT INTO service_events
			  (event_id)
			  VALUES ('".$event_id."')";
	$result = mysql_query($query);
}
function delete_leader(){
	$user_id = $_POST['user_id'];
	$schedule_id = $_POST['schedule_id'];
	$query = "DELETE FROM service_leaders
			  WHERE ".$user_id."= user_id 
			  AND ".$schedule_id."= schedule_id";
	$result = mysql_query($query);
}
function delete_event(){
	$event_id = $_POST['event_id'];
	$query = "DELETE FROM serive_events
			  WHERE '".$event_id."'= event_id";
	$result = mysql_query($query);
}
/* what variables? start_time end_time DOW default_length */
function modify_event(){
	$schedule_id = $_POST['schedule_id'];
	$variables = $_POST['variables'];
	$query = "UPDATE service_events
			  SET variables = ".$variables."
			  WHERE event_id = ".$event_id;
	$result = mysql_query($query);
}
/* go on rs_hours, occurence id per person per occurence */ 
function record_attendance(){
}



