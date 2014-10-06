<?php
$result = '';
require_once ('layout.php');
require_once ('mysql_access.php');

function top_hours() {
	global $current_semester;
	$sql = "SELECT contact_information.firstname, contact_information.lastname, SUM( hours ) AS  `sum_hours` FROM  `recorded_hours` ,  `contact_information` WHERE contact_information.id = recorded_hours.user_id AND `semester` = '$current_semester' GROUP BY (`user_id`) ORDER BY  `sum_hours` DESC LIMIT 10";
	$result = mysql_query($sql);
	
	$i = 1;
	while($row = mysql_fetch_array($result)) {
		$row_num = "";
		if ( ($i % 2) == 0) {
			$row_num = "class='row_1'";
		} else {
			$row_num = "class='row_2'";
		}
		//echo "<tr $row_num><td><b>$row[firstname] $row[lastname]</b></td><td>$row[sum_hours]</td></tr>";
		echo<<<END
		<div class="contact" style="padding: 10px;">

	<div style='display:inline-block; font-size: 30px; padding: 20px; width: 70px; text-align: right; font-family: Garalde; font-weight: bold;'>$i</div>

	<div class='info' style='display:inline-block; font-size: 30px; width: 300px; font-family: Garalde; padding-top: -20px;'>
	$row[firstname] $row[lastname]
	</div>

	<div class='info' style='display:inline-block; font-size: 30px; padding: 20px; font-family: Garalde'>
	$row[sum_hours]
	</div>

	
	</div>
	<br clear='both'/>
END;
		//echo "<tr><td> $i </td><td>$row[firstname] $row[lastname] </td><td>$row[sum_hours]</td>";
		$i += 1;
	}
	//echo "</table>";
}

function Pledge_hours() {
	global $current_semester;
	$sql = "SELECT SUM(`hours`) AS sum_hours, contact_information.status FROM `recorded_hours`, `contact_information` WHERE recorded_hours.user_id = contact_information.id AND `semester` = '$current_semester' AND `event` = 'Blood Drive' AND `status` = 'Pledge' AND `month` >=10 GROUP BY contact_information.status";
	$result = mysql_query($sql);
	
	
	$sql2 = "SELECT `status`, COUNT(`lastname`) AS 'members' FROM `contact_information` GROUP BY `status`";
	$result2 = mysql_query($sql2);

	
	$fam_flower_array = array();
	while ($row = mysql_fetch_array($result2)) {
		$fam_flower_array[$row[famflower]] = $row['members'];
	}
	
	echo "<table cellpadding=0 cellspacing=0 class='hours'><tr class='header'><td><b>Pledge Hours</b></td><td><b>Hours</b></td><td><b>HPM*</b></tr>";
	$i = 1;
	while($row = mysql_fetch_array($result)) {
		$row_num = "";
		if ( ($i % 2) == 0) {
			$row_num = "class='row_1'";
		} else {
			$row_num = "class='row_2'";
		}
		
		$hours_per_member = round($row['sum_hours'] / $fam_flower_array[$row[famflower]], 3);
		echo "<tr $row_num><td><b>$row[status]</b></td><td>$row[sum_hours]</td><td>$hours_per_member</tr>\n";
		$i += 1;
	}
	echo "</table>";
	echo "<p><i>*HPM: Hours Per Member</i></p>";
	
	$sql21 = "SELECT SUM(`hours`) AS sum_hours2 FROM `recorded_hours`, `contact_information` WHERE recorded_hours.user_id = contact_information.id AND `event` = 'Blood Drive' AND `status` != 'Pledge' AND `status` != 'Early Alum' AND `month` >=10";
	$result21 = mysql_query($sql21);
	
	$number_actives = 130;
	
	echo "<table cellpadding=0 cellspacing=0 class='hours'><tr class='header'><td><b>Active Hours</b></td><td><b>Hours</b></td><td><b>HPM*</b></tr>";
	$i = 1;
	while($row = mysql_fetch_array($result21)) {
		$row_num2 = "";
		if ( ($i % 2) == 0) {
			$row_num = "class='row_1'";
		} else {
			$row_num = "class='row_2'";
		}
		
		$hours_per_member2 = round($row['sum_hours2'] / $number_actives, 3);
		echo "<tr $row_num><td><b>Actives</b></td><td>$row[sum_hours2]</td><td>$hours_per_member2</tr>\n";
		$i += 1;
	}
	echo "<p>Total hours by Actives.</p>";
	echo "</table>";
	echo "<p><i>*HPM: Hours Per Member</i></p>";
	if ($hours_per_member2 > $hours_per_member) {
		$difference_per_member = ($hours_per_member2 - $hours_per_member);
		echo "Actives are winning by $difference_per_member hours per member.";
	} else {
		$difference_per_member2 = ($hours_per_member - $hours_per_member2);
		echo "Pledges are winning by $difference_per_member2 hours per member.";
	}
}



page_header();

?>

<style>
tr.row_1{
background: #CCC;
}
tr.header{
background: #BBB;
}
table.hours td{
padding: 5px 10px;
}
table.hours
</style>

<div class="content">


<?php
if (!isset($_SESSION['sessionID'])) {

		echo "<p>You need to login before you can see the rest of this section.</p>"; 

	} else {
		echo "<h2>Fall 2011 Blood Drive Challenge Event</h2>";
	echo "<p>Total hours by Pledges.</p>";
	Pledge_hours();
	
	}

?>

</div>

<?php

page_footer();

?>