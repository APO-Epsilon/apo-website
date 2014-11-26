c<?php
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

		$start_of_competition = date('Y-m-d', mktime(0,0,0,3, 19, 2011));
		$end_of_competition = date('Y-m-d', mktime(0,0,0,4, 17, 2011));
		
		$sql = "SELECT SUM( recorded_hours.hours ) AS  `sum_hours` FROM `recorded_hours` WHERE recorded_hours.date >= '$start_of_competition' AND recorded_hours.date <= '$end_of_competition'";			
		echo "<h2> Total hours logged from $start_of_competition to $end_of_competition </h2>";
		
		echo "<p>This page was created to track how many hours have been recorded for the APO, ASG, TLS service competition. Spring 2011</p>";
		$result = mysql_query($sql);
		echo "<table><tr><td><b>Total Chapter</b></td><td><b>Hours</b></td></tr>";
		while($row = mysql_fetch_array($result)) {
			echo "<tr><td></td><td>$row[sum_hours]</td></tr>";
		}
		echo "</table>";
		
		
		$sql = "SELECT SUM( recorded_hours.hours ) AS `sum_hours`, `status` FROM  `contact_information`, `recorded_hours` WHERE recorded_hours.user_id = contact_information.id AND recorded_hours.date >= '$start_of_competition' AND recorded_hours.date <= '$end_of_competition' GROUP BY contact_information.status ORDER BY sum_hours DESC";			
		//echo $sql;
		$result = mysql_query($sql);
		echo "<table><tr><td><b>Status</b></td><td><b>Hours</td></td></tr>";
		while($row = mysql_fetch_array($result)) {
			echo "<tr><td>$row[status]</td><td>$row[sum_hours]</td></tr>";
		}
		echo "</table>";
		
		echo "<p>Here are those wonderful folks who logged the most hours during the competition.</p>";
		
		$sql = "SELECT firstname, lastname, SUM( recorded_hours.hours ) AS  `sum_hours` FROM  `contact_information`, `recorded_hours` WHERE recorded_hours.user_id = contact_information.id AND recorded_hours.date >= '$start_of_competition' AND recorded_hours.date <= '$end_of_competition' GROUP BY contact_information.id ORDER BY sum_hours DESC LIMIT 10";
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

?>

</div>
<?php
page_footer();
?>