<?php
$result = '';
require_once ('layout.php');
require_once ('mysql_access.php');

function list_hours() {
	global $current_semester;
	$sql = "SELECT firstname, lastname, SUM( recorded_hours.hours ) AS  `sum_hours`, email FROM  `contact_information`, `recorded_hours` WHERE recorded_hours.user_id = contact_information.id AND recorded_hours.semester = '$current_semester' GROUP BY contact_information.id ORDER BY  `sum_hours` DESC";
	//echo $sql;
	$result = mysql_query($sql);
	
	echo "<table cellpadding=0 cellspacing=0 class='hours'><tr class='header'><td><b>Name</b></td><td><b>Hours</b></td><td><b>Email</b></td></tr>";
	$i = 1;
	while($row = mysql_fetch_array($result)) {
		$row_num = "";
		if ( ($i % 2) == 0) {
			$row_num = "class='row_1'";
		} else {
			$row_num = "class='row_2'";
		}
		echo "<tr $row_num><td><b>$row[firstname] $row[lastname]</b></td><td>$row[sum_hours]</td><td>$row[email]</td></tr>";
		$i += 1;
	}
	echo "</table>";
	
}

function list_fund_hours() {
	global $current_semester;
	$sql = "SELECT firstname, lastname, SUM( recorded_hours.hours ) AS `sum_hours`, email FROM `contact_information` , `recorded_hours` WHERE recorded_hours.user_id = contact_information.id AND recorded_hours.semester = '$current_semester' AND recorded_hours.fundraising = '1' GROUP BY contact_information.id ORDER BY `sum_hours` DESC";
	//echo $sql;
	$result = mysql_query($sql);
	
	echo "<table cellpadding=0 cellspacing=0 class='hours'><tr class='header'><td><b>Name</b></td><td><b>Hours</b></td><td><b>Email</b></td></tr>";
	$i = 1;
	while($row = mysql_fetch_array($result)) {
		$row_num = "";
		if ( ($i % 2) == 0) {
			$row_num = "class='row_1'";
		} else {
			$row_num = "class='row_2'";
		}
		echo "<tr $row_num><td><b>$row[firstname] $row[lastname]</b></td><td>$row[sum_hours]</td><td>$row[email]</td></tr>";
		$i += 1;
	}
	echo "</table>";
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
		echo "<p>Total hours for each member.  Please note that this does not list members for whom no hours have been logged.</p>";
	list_hours();
	echo "<p>Total Fundraising Hours for each member </p>";
	list_fund_hours();
}

?>

</div>
<?php
page_footer();
?>