<?php
require_once ('layout.php');
require_once ('mysql_access.php');

page_header();

if (!isset($_SESSION['sessionID'])) {
	echo '<strong>You need to login before you can see this section.</strong>'; 
} else {
	echo "
<div class=\"content\">
<h1>Committee Times</h1>
Here are the current committee times and locations that have been set by the exec board.<p>
";


//further development of this page should make the next scheduled committee time display
//for each position. Committee leaders should be encouraged to schedule their committees
//in advance.
$sql = "SELECT position, position_order, comm_day,
		comm_time, comm_location
	 	FROM positions 
	 	WHERE comm_active = 1 
	 	ORDER BY position_order";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
	$position = $row['position'];
	$comm_time = $row['comm_time'];
	$comm_location = $row['comm_location'];
	$comm_day = $row['comm_day'];

$sql1 = "SELECT o.date AS date
		FROM committee_occurrence AS o
		JOIN positions AS p
		ON p.position_id = o.position_id
		WHERE p.position = '".$position."'
		ORDER BY date";
$result1 = mysql_query($sql1);
while($row1 = mysql_fetch_array($result1)){
	$next_committee = $row1['date'];
}
	$todays_date = date("Y-m-d");

	$today = strtotime($todays_date);
	$next_date = strtotime($next_committee);

	if ($next_date >= $today) {
	     $valid = true;
	} else {
	     $valid = false;
	}

if(($row['comm_day'] != '')||($row['comm_time'] != '')||($row['comm_location'] != '')||($row1['date'] != '')){
echo "
<ul>
	<li><b>{$position}</b>
	<ul>";}
if($valid){
	echo "<li>next committee: ".$next_committee."</li>";
}
if($row['comm_day']!= ''){echo "
		<li>$comm_day</li>";}
if($row['comm_time']!= ''){echo "
		<li>$comm_time</li>";}
if($row['comm_location']!= ''){echo "
		<li>$comm_location</li>";}
echo "
	</ul>
	</li>
</ul>
";
	}
}
echo "</div>";
page_footer();
?>