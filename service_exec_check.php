<?php
$result = '';
require_once ('layout.php');
require_once ('mysql_access.php');

global $current_semester;
global $previous_semester;

function process_form() {	
	$id = $_SESSION['sessionID'];
	$event = $_POST['event'];
	$month = $_POST['month']; 
    $day = $_POST['day'];
    $year = $_POST['year'];
    $date = "$year-$month-$day";
	$description = $_POST['description'];
	$hours = $_POST['hours'];
	$hours = round($hours, 2);
	$servicetype = $_POST['servicetype'];
	$fundraising = $_POST['fundraising'];
	$semester = $_POST['semester'];

	$description = htmlspecialchars($description, ENT_QUOTES);

	if ($month == NULL || $day == NULL || $event == NULL || $hours == NULL || $servicetype == NULL) {
		$result = "Your didn't fill out the form completely.<br/>";
	}
	else if ($description == 'Ray Miller' ||$description == 'Twin Pines' ||$description == 'Humane Society' ||$description == 'Adair Co. Library' ||$description == 'Recycling Center' ||$description == 'Bought Hours' ||$description == 'Camp' ||$description == 'Bake sale' ||$description == 'Large Service Project' ||$description == 'Other Service Project' ||$description == 'Non-APO Hours') {
		$result = "<div class='entry'>The description cannot be the same as the event. Please enter a valid description so that exec can verify that you did the service hours. <br/></div>";
	}
	else {
		$insert = "insert into apo.recorded_hours (user_id, event, month, day, year, date, description, hours, servicetype, fundraising, semester) values('$id', '$event', '$month','$day', '$year', '$date', '$description', '$hours', '$servicetype', '$fundraising', '$semester');";
		$query2 = mysql_query($insert) or die("If you encounter problems, please contact the webmaster.");
		$result = '1';
END;
	}
return $result;
}
function list_stats($hours_id, $semester) {	
	// Total Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		$total_hours = round($i['sum_hours'], 2);
		echo "<span>Total Hours:</span> $total_hours<br/>";
	}	
	// APO Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `event` != 'Non-APO Hours'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) {
		$apo_hours = round($i['sum_hours'], 2);
		echo "<span>APO Hours:</span> $apo_hours<br/>";
	}	
	// Chapter Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Chapter'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");
	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Chapter Hours:</span> $i[sum_hours]<br/>";
	}	
	// Campus Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Campus'  AND `semester` = '$semester' LIMIT 1";	
	$results = mysql_query($sql) or die("Error Calculating Hours");
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Campus Hours:</span> $i[sum_hours]<br/>";
	}	
	// Community Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Community'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");	
	while($i = mysql_fetch_array($results)) { 
		$community_hours = round($i['sum_hours'], 2);
		echo "<span>Community Hours:</span> $community_hours<br/>";
	}	
	// Country Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `servicetype` = 'Country'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Country Hours:</span> $i[sum_hours]<br/>";
	}		
	// Fundraising Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `fundraising` = '1'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Fundraising Hours:</span> $i[sum_hours]<br/>";
	}
	// Bought Hours
	$sql = "SELECT SUM(hours) AS sum_hours FROM `recorded_hours` WHERE `user_id` = $hours_id AND `event` = 'Bought Hours'  AND `semester` = '$semester' LIMIT 1";
	$results = mysql_query($sql) or die("Error Calculating Hours");	
	while($i = mysql_fetch_array($results)) { 
		echo "<span>Bought Hours:</span> $i[sum_hours]<br/>";
	}
}
function top_hours() {
	$sql = "SELECT contact_information.firstname, contact_information.lastname, SUM( hours ) AS  `sum_hours` 
		FROM  `recorded_hours` ,  `contact_information` 
		WHERE contact_information.id = recorded_hours.user_id
		GROUP BY (`user_id`)
		ORDER BY  `sum_hours` DESC 
		LIMIT 5";
}
page_header();
?>
<div class="content">
<?php
function list_hours($user_id) {	
	$sql = "SELECT * FROM `recorded_hours` WHERE `user_id` = $user_id ORDER BY `year` DESC, `month` DESC, `day` DESC";
	$results = mysql_query($sql) or die("Error - Contact Webmaster");	
	echo "<div style='margin: 0px auto; width: 100%; text-align: center;'>
	<table cellpadding='0' cellspacing='0' class='hours_table'>
	<tr class='hours_header'><td>Event</td><td>Date</td><td>Type</td><td>Hours</td><td>Description</td><td>Semester</td><td></td></tr>";
	$inc = 1;
	while ($i = mysql_fetch_array($results)) {
		if (($inc % 2) == 1) {
			$hours_line = "class='hours_row1'";
		} else {
			$hours_line = "class='hours_row2'";
		}		
		$fund = "";
		if ($i['fundraising'] == 1) {
			$fund = "<img src='http://apo.truman.edu/layout_files/fundraising_coin.jpeg' style='vertical-align: middle;' title='Fundraising!' alt='Fundraising!'/>";
		}
		echo "<tr $hours_line><td width='20%'>$i[event]</td>
		<td width='15%'> $i[month] / $i[day] / $i[year] </td>
		<td width='10%'> $i[servicetype] </td>
		<td style='text-align: center;'> $i[hours] $fund</td>
		<td> $i[description] </td>
		<td width='15%'>$i[semester]</td>
		</tr>";	
		$inc = $inc + 1;
	}
	echo "</table></div>";
}
if ($_SESSION['sessionexec'] == 0) {
		echo "<p>Only execs can see this page.</p>"; 
	} elseif ($_SESSION['sessionexec'] == 1 or $_SESSION['sessionexec'] == 2) {
//$sql = "SELECT `id`,`firstname`, `lastname` FROM `contact_information` WHERE `active_sem` = '$current_semester' ORDER BY `firstname`";
$sql = "SELECT `id`,`firstname`, `lastname` FROM `contact_information` WHERE 1 ORDER BY `firstname`";
$result = mysql_query($sql);				
echo<<<END
<h1>Service Hours</h1>
<p>This page is for checking the hours which members have logged.</p>
<p>
<form action="service_exec_check.php" method="GET">
<label for="user_id">Members</label>
	<select name="user_id">
END;
	while($row = mysql_fetch_array($result)) {
		echo "<option value='$row[id]'>$row[firstname] $row[lastname]</option>";
	}
echo<<<END
	</select>
	&nbsp;&nbsp;
<input type='submit' value='List Hours'/>
</form>
</p>

END;
if (isset($_GET['user_id'])) {
	$sql = "SELECT `firstname`, `lastname`, `status` FROM `contact_information` WHERE `id`='$_GET[user_id]' LIMIT 1";
	$result = mysql_query($sql);	
	$row = mysql_fetch_array($result);	
	echo "<p>Hours logged by <b>$row[firstname] $row[lastname]</b> (<i>$row[status]</i>).</p>";
	$user_id = $_GET['user_id'];
	list_stats($user_id, $current_semester);
	list_hours($user_id, $current_semester);	
	echo "<div id='service_log2' style='margin: 30px; padding: 15px;'>";	
	echo "</div>";
		echo "<br clear='both'/>";	
}
	}
?>

</div>
<div style="clear:both" />
</div>
<div class="content_left">
<?php /*
echo "Here are the members that have not met the service requirements for this semester.";
$sql1 = "SELECT firstname, lastname, SUM( recorded_hours.hours ) AS  `sum_hours` FROM  `contact_information`, `recorded_hours` WHERE recorded_hours.user_id = contact_information.id AND `status` != 'Early Alum' AND `status` != 'Associate' AND `semester` = '$current_semester' GROUP BY contact_information.id";
$result1 = mysql_query($sql1);
echo "<h2>Actives</h2>";
echo "<table><tr><td><b>Name</b></td><td><b>Hours</b></td></tr>";
while($row1 = mysql_fetch_array($result1)) {
	if ($row1['sum_hours'] <= 24) {
	echo "<tr><td>$row1[firstname] $row1[lastname]</td><td>$row1[sum_hours]</td></tr>";
	}
}			
echo "</table>";
$sql2 = "SELECT firstname, lastname, SUM( recorded_hours.hours ) AS  `sum_hours` FROM  `contact_information`, `recorded_hours` WHERE recorded_hours.user_id = contact_information.id AND `status` = 'Associate' AND `semester` = '$current_semester' GROUP BY contact_information.id";
$result2 = mysql_query($sql2);
echo "<h2>Associates</h2>";
echo "<table><tr><td><b>Name</b></td><td><b>Hours</b></td></tr>";
while($row2 = mysql_fetch_array($result2)) {
	if ($row2['sum_hours'] <= 11) {
	echo "<tr><td>$row2[firstname] $row2[lastname]</td><td>$row2[sum_hours]</td></tr>";
	}
}			
echo "</table>";
?>
</div>
<div class="sidebar">
<?php
$sql = "SELECT firstname, lastname, SUM( recorded_hours.hours ) AS  `sum_hours` FROM  `contact_information`, `recorded_hours` WHERE recorded_hours.user_id = contact_information.id AND `fundraising` = 1 OR `fundraising` = 'NULL'  AND `semester` = '$current_semester' GROUP BY contact_information.id";
$result = mysql_query($sql);
$sql3 = "SELECT firstname, lastname, COUNT(recorded_hours.fundraising) AS `no_hours` FROM `contact_information`, `recorded_hours` WHERE recorded_hours.user_id = contact_information.id AND `fundraising` != 1 AND `semester` = '$current_semester' GROUP BY contact_information.id";
$result3 = mysql_query($sql3);
echo "<h2>Members with less than 3 Fundraising Hours.</h2>";
echo "<table><tr><td><b>Name</b></td><td><b>Hours</b></td></tr>";
while($row = mysql_fetch_array($result)) {
	if ($row['sum_hours'] <= 2) {
	echo "<tr><td>$row[firstname] $row[lastname]</td><td>$row[sum_hours]</td></tr>";
	} else if ($row['sum_hours'] = 0) {
		echo "<tr><td>$row[firstname] $row[lastname]</td><td>0</td></tr>";
	}
}
while($row3 = mysql_fetch_array($result3)) {
	//echo "<tr><td>$row3[firstname] $row3[lastname]</td><td>$row3[no_hours]</td></tr>";
}
echo "</table>";
*/ ?>
</div>
<?php
page_footer();
?>