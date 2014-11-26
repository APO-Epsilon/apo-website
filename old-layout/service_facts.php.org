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

function family_hours() {
	global $current_semester;
	$sql = "SELECT SUM(`hours`) AS sum_hours, contact_information.famflower FROM `recorded_hours`, `contact_information` WHERE recorded_hours.user_id = contact_information.id AND `semester` = '$current_semester' AND (contact_information.status = 'Active' OR contact_information.status = 'Pledge' OR contact_information.status = 'Elected' OR contact_information.status = 'Appointed') GROUP BY contact_information.famflower";
	$result = mysql_query($sql);
	
	
	$sql2 = "SELECT `famflower`, COUNT(`lastname`) as 'members' FROM `contact_information` WHERE status = 'Active' OR status = 'Pledge' OR status = 'Elected' OR status = 'Appointed' GROUP BY `famflower`";
	$result2 = mysql_query($sql2);

	
	$fam_flower_array = array();
	while ($row = mysql_fetch_array($result2)) {
		$fam_flower_array[$row[famflower]] = $row['members'];
	}
	
	echo "<table cellpadding=0 cellspacing=0 class='hours'><tr class='header'><td><b>Family Hours</b></td><td><b>Hours</b></td><td><b>HPM*</b></tr>";
	$i = 1;
	while($row = mysql_fetch_array($result)) {
		$row_num = "";
		if ( ($i % 2) == 0) {
			$row_num = "class='row_1'";
		} else {
			$row_num = "class='row_2'";
		}
		
		$hours_per_member = round($row['sum_hours'] / $fam_flower_array[$row[famflower]], 1);
		echo "<tr $row_num><td><b>$row[famflower]</b></td><td>$row[sum_hours]</td><td>$hours_per_member</tr>\n";
		$i += 1;
	}
	echo "</table>";
	echo "<p><i>*HPM: Hours Per Member</i></p>";
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
		echo "<p> Here you can find the brothers with the most recorded hours.  Congratulate them for their hard work!</p>";	
	top_hours();
	echo "<p>Total hours by Family Flower.</p>";
	family_hours();

	}

?>

</div>
<?php
page_footer();
?>