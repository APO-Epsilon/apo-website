<?php
require_once('layout.php');
require_once('mysql_access.php');

page_header();
$user_id = $_SESSION['sessionID'];
if($user_id != 378){
	die("you do not have access to this page");
}


$sql = "SELECT committee_attendance.committee_id AS comm_id, 
		committee_attendance.id AS user_ids, committee_occurrence.date AS date,
		committee_occurrence.position_id AS pos_id_occ, 
		positions.position_id AS pos_id_pos, positions.position AS position
		FROM positions
		LEFT JOIN committee_occurrence
		ON committee_occurrence.position_id = positions.position_id
		LEFT JOIN committee_attendance
		ON committee_attendance.committee_id = committee_occurrence.committee_id
		WHERE date IS NOT NULL 
		ORDER BY date ASC
		LIMIT 20";

$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){
		$position = $row['position'];
		$date = $row['date'];
		$user_ids = $row['user_ids'];
		echo($position."  ".$date."  ".$user_ids."<p>");
	}

page_footer();
?>