<?php
$result = '';
require_once ('layout.php');
require_once ('mysql_access.php');

function top_hours() {
	$sql = "SELECT firstname, lastname, SUM( recorded_hours.hours ) AS  `sum_hours` FROM  `contact_information`, `recorded_hours` WHERE recorded_hours.user_id = contact_information.id AND recorded_hours.semester = 'Fall 2010' GROUP BY contact_information.id ORDER BY  contact_information.lastname ASC";
	$result = mysql_query($sql);
	
	echo "<table cellpadding=0 cellspacing=0 class='hours'><tr class='header'><td><b>Name</b></td><td><b>Hours</b></td></tr>";
	$i = 1;
	while($row = mysql_fetch_array($result)) {
		$row_num = "";
		if ( ($i % 2) == 0) {
			$row_num = "class='row_1'";
		} else {
			$row_num = "class='row_2'";
		}
		echo "<tr $row_num><td><b>$row[firstname] $row[lastname]</b></td><td>$row[sum_hours]</td></tr>";
		$i += 1;
	}
	echo "</table>";
}

function family_hours() {
	$sql = "SELECT SUM(`hours`) AS sum_hours, contact_information.famflower FROM `recorded_hours`, `contact_information` WHERE recorded_hours.user_id = contact_information.id GROUP BY contact_information.famflower";
	$result = mysql_query($sql);
	
	
	$sql2 = "SELECT `famflower`, COUNT(`lastname`) as 'members' FROM `contact_information` GROUP BY `famflower`";
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

		$i = 0;
		while (date("l", mktime(0, 0, 0, 1, 1 + $i, 2011)) != "Sunday") {
			$i = $i + 1;
		}
		
		$i += 1;
		$j = 0;
		$first_of_week = date('Y-m-d', mktime(0,0,0,1, $i, 2011));
		
		while ($first_of_week <= date('Y-m-d')) {
			$first_of_week = strtotime($first_of_week . ' + 7 day');
			$first_of_week = date('Y-m-d', $first_of_week);
			
			$end_of_week = strtotime($first_of_week . ' + 6 day');
			$end_of_week = date('Y-m-d', $end_of_week);
			$j += 1;
		
		
			$sql = "SELECT firstname, lastname, SUM( recorded_hours.hours ) AS  `sum_hours` FROM  `contact_information`, `recorded_hours` WHERE recorded_hours.user_id = contact_information.id AND recorded_hours.date >= '$first_of_week' AND recorded_hours.date <= '$end_of_week' GROUP BY contact_information.id ORDER BY  sum_hours DESC LIMIT 10";			

			$date_title = date('F j', strtotime($first_of_week));
			echo "<h2>Most hours logged for week of $date_title</h2>";
			
			$result = mysql_query($sql);
			echo "<table><tr><td><b>Name</b></td><td><b>Hours</b></td></tr>";
			while($row = mysql_fetch_array($result)) {
				echo "<tr><td>$row[firstname] $row[lastname]</td><td>$row[sum_hours]</td></tr>";
			}
			echo "</table>";
		}

	}

?>

</div>
<?php
page_footer();
?>