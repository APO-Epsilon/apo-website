<?php
require_once ('mysql_access.php');

	$id = $_GET['id'];
	$sql = "SELECT events.name AS name, occurrence.date AS date, occurrence.id AS id
			FROM events
			JOIN occurrence
			ON events.e_id=occurrence.e_id
			WHERE occurrence.id = '".$id."'
			ORDER BY occurrence.date";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
					$event = $row['name'];
					$date = $row['date'];
		}
		echo("{$event}--{$date}<p>");	
		
	$sql = "SELECT contact_information.id AS id, contact_information.firstname,
			contact_information.lastname, recorded_attendance.attended,
			recorded_attendance.user_id
			FROM contact_information
			JOIN recorded_attendance
			ON contact_information.id=recorded_attendance.user_id	
			WHERE contact_information.status != 'Alumni' 
			AND contact_information.status != 'Inactive' 
			AND contact_information.status != 'Advisor'
			AND recorded_attendance.id = $id
			AND recorded_attendance.attended = 1
			ORDER BY lastname, firstname DESC";
		$result = mysql_query($sql);
		
		$num_rows = mysql_num_rows($result);
		for ($i=0;$i<$num_rows;$i++){
			$ids;
			$row = mysql_fetch_assoc($result);
			$ids[$i] = $row['id'];	
		}
		foreach($ids as $index => $value){
			$sql = "SELECT firstname, lastname FROM `apo`.`contact_information` WHERE id = $value";
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)){
					$firstname = $row['firstname'];
					$lastname = $row['lastname'];
				}
				echo("{$lastname}, {$firstname}<br/>");
} 