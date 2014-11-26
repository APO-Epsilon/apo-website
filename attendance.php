<?php
require_once ('session.php');
?>
<!doctype html>
<html>
<head>
    <?php require 'head.php';?>
</head>

<body>
    <!-- Javascript method to include navigation -->
    <nav id="nav" role="navigation"><?php include 'nav.php';?></nav>
    <!-- PHP method to include navigation -->

    <!-- Javascript method to include header -->
    <div id="header"><?php include 'header.php';?></div>
    <!-- PHP method to include header -->

<?php
require_once ('mysql_access.php');
page_header();
echo("<div class=\"row\">");
$user_id = $_SESSION['sessionID'];
if (!isset($_SESSION['sessionID'])) {

		echo "<p>You need to login before you can see the rest of this section.</p>";
}else{

	$sql = "SELECT status AS status FROM contact_information WHERE id = '".$_SESSION['sessionID']."'";
		$result = mysql_query($sql);
			if($result){
				while($row = mysql_fetch_array($result)){
					$sessionStatus = $row['status'];
				}
			}

		if($sessionStatus == 'Pledge'){
			die("Attendance is not currently recorded for pledges");
		}

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

	$sql = "SELECT COUNT(*) AS num_missed
			FROM occurrence
			LEFT JOIN events ON occurrence.e_id = events.e_id
			LEFT JOIN recorded_attendance ON occurrence.id = recorded_attendance.id
			WHERE recorded_attendance.user_id = ".$user_id." AND recorded_attendance.attended = 0
			ORDER BY occurrence.id ASC";
	$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$num_missed_total = $row['num_missed'];
		}

	$sql = "SELECT COUNT(id) AS committee_count FROM committee_attendance WHERE id = ".$user_id." AND attended = 1";
	$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$committee_count = $row['committee_count'];
		}
		echo "
		<b>Total Absences: {$num_missed_total}</b><br/>
		{$name}: {$num_missed}<br/>";

		if($committee_count > 0){
			echo "<b>Total Committees: {$committee_count}</b>";
		}
}

	$sql = "SELECT occurrence.e_id AS e_id, occurrence.id AS id, occurrence.date AS date,
			events.name AS name, events.worth AS worth, occurrence.type AS type,
			recorded_attendance.attended AS attended
			FROM occurrence
			LEFT JOIN events ON occurrence.e_id = events.e_id
			LEFT JOIN recorded_attendance ON occurrence.id = recorded_attendance.id
			WHERE recorded_attendance.user_id = '".$user_id."'
			ORDER BY occurrence.date DESC";
		$result = mysql_query($sql);
		if($result){
		}
echo<<<END
<h1>My Attendance</h1>

END;
		list_attendance_stats($user_id);
		echo
				"</div>
				<div class='row'>
				<p>
				<br/>
				<div>
				<table class='large-12 medium-12 small-12 column'>
				<tr class='hours_header'>
					<td></td>
					<td>Event</td>
					<td>Date</td>
					<td>Worth</td>
					<td>Attended</td>
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
			<td width='33%'>$name</td>
			<td width='30%'>$date</td>
			<td width='12%'>$worth</td>
			<td width='15%'>$attended</td>
			<td width='5%'></td>
		</tr>";
	}
	echo "</table></div></div><hr>";

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
echo "		<div class='row'>
				<table class='large-12 medium-12 small-12 column'>
				<tr class='hours_header'>
					<td></td>
					<td><strong>Committee</strong></td>
					<td><strong>Date</strong></td>
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
					<td width='55%'>$position</td>
					<td width='35%'>$date</td>
					<td width='5%'></td>
				</tr>";
}
echo("</table></div>");}}
?>
    <!-- Javascript method to include footer -->
    <div id="footer"><?php include 'footer.php';?></div>
    <!-- PHP method to include footer -->
</body>
</html>