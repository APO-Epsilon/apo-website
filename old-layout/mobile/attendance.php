<?php
echo <<<END
<!DOCTYPE html>
<head>
	<meta name="viewport" content="user-scalable=no, width=device-width"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="stylesheet" type="text/css" href="/includes/css/iphone.css" media="screen"/>
</head>
<body>
    <div>
      <div class="button" onclick="window.location = 'http://apo.truman.edu/mobile.php';">Home</div>
      <h1>Alpha Phi Omega</h1>
      <h2>My Attendance</h2>
END;
require_once ('../layout.php');
require_once ('../mysql_access.php');
echo("<div class=\"content\">");
$user_id = $_SESSION['sessionID'];
if (!isset($_SESSION['sessionID'])) {

		echo "<p>You need to login before you can see the rest of this section.</p>"; 
}else{
function list_attendance_stats($user_id){

	$sql = "SELECT 
			events.name AS name, SUM(events.worth) AS sum_worth, events.worth AS worth
			FROM occurrence 
			LEFT JOIN events ON occurrence.e_id = events.e_id
			LEFT JOIN recorded_attendance ON occurrence.id = recorded_attendance.id
			WHERE recorded_attendance.user_id = ".$user_id."
			AND events.name = 'Active Meeting'
			ORDER BY occurrence.id ASC";
	$result = mysql_query($sql);	
		while($row = mysql_fetch_array($result)){
			$name = $row['name'];
			$sum_worth = $row['sum_worth'];
			$worth = $row['worth'];
		}
	$sql = "SELECT COUNT(*) AS num_missed
			FROM occurrence 
			LEFT JOIN events ON occurrence.e_id = events.e_id
			LEFT JOIN recorded_attendance ON occurrence.id = recorded_attendance.id
			WHERE recorded_attendance.user_id = ".$user_id." AND events.name = 'Active Meeting'
			AND recorded_attendance.attended = 0
			ORDER BY occurrence.id ASC";
	$result = mysql_query($sql);	
		while($row = mysql_fetch_array($result)){
			$num_missed = $row['num_missed'];
		}
		echo "
		<li><strong>Total Absences:</strong><br/>
		{$name}: {$num_missed}</li>";

		
}
	$sql = "SELECT occurrence.e_id AS e_id, occurrence.id AS id, occurrence.date AS date,
			events.name AS name, events.worth AS worth, occurrence.type AS type, 
			recorded_attendance.attended AS attended
			FROM occurrence 
			LEFT JOIN events ON occurrence.e_id = events.e_id
			LEFT JOIN recorded_attendance ON occurrence.id = recorded_attendance.id
			WHERE recorded_attendance.user_id = '".$user_id."'
			ORDER BY occurrence.date, occurrence.id ASC";
		$result = mysql_query($sql);
		if($result){
		}
		list_attendance_stats($user_id);
		echo
				"<li><p><table cellpadding='0' cellspacing='0' class='hours_table'>
				<tr class='hours_header'><strong>Meeting Attendance</strong>
				<td></td>
				<td><b>Event</b></td>
				<td><b>Date</td>
				<td><b>Worth</b></td>
				<td><b>Attended</b></td>
				<td></td>
				</tr>";
			while($row = mysql_fetch_array($result)){
				$e_id = $row['e_id'];
				$event_id = $row['id'];
				$date = $row['date'];
				$name = $row['name'];
				$worth = $row['worth'];
				$type = $row['type'];
				$attended = $row['attended'];
				
				if($attended == 1){
					$attended = "yes";
				}else{
					$attended = "no";
				}
	
	echo"		
		<tr>		
		<td width='5%'></td>
		<td width='25%'>$name</td>
		<td width='25%'>$date</td>
		<td width='20%'>$worth</td>
		<td width='20%'>$attended</td>
		<td width='5%'></td>
		</tr>";	
	}
	echo "</table>";
	
	$sql = "SELECT committee_attendance.committee_id AS comm_id, 
			committee_occurrence.position_id AS position_id, 
			positions.position AS position, committee_occurrence.date AS date
			FROM committee_attendance
			LEFT JOIN committee_occurrence ON committee_attendance.committee_id = committee_occurrence.committee_id
			LEFT JOIN positions ON committee_occurrence.position_id = positions.position_id
			WHERE committee_attendance.id = ".$user_id."
			ORDER BY committee_occurrence.date ASC";
	$result = mysql_query($sql);
	if(mysql_num_rows($result)!=0){
echo "		<li><p><table cellpadding='0' cellspacing='0' class='hours_table'>
				<tr class='hours_header'><strong>Committee Attendance</strong><p>
				<td></td>
				<td><b>Committee</b></td>
				<td></td>
				<td><b>Date</b></td>
				<td></td>
				</tr>";
			while($row = mysql_fetch_array($result)){
			$comm_id = $row['comm_id'];
			$position_id = $row['position_id'];
			$position = $row['position'];
			$date = $row['date'];
			
				
echo "
				<tr>		
				<td width='5%'></td>
				<td width='35%'>$position</td>
				<td width='20%'></td>
				<td width='35%'>$date</td>
				<td width='5%'></td>
				</tr>";	
}
echo("</table></div></li>");}};
?>